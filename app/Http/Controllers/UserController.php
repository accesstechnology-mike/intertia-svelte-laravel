<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Auth;
use App\Models\Log;
use Carbon\Carbon;
use App\Models\Client;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{


    public function index()
    {
        //get authenticated user
        $user = Auth::user();
        // if user has permission to show users, show them


        if ($user->hasPermissionTo('read users')) {
            //get all users where active is not 0
            $users = User::with(['roles', 'permissions'])
                ->where('active', '!=', 0)
                ->leftJoin(
                    'model_has_roles',
                    'users.id',
                    '=',
                    'model_has_roles.model_id'
                )
                ->leftJoin(
                    'roles',
                    'model_has_roles.role_id',
                    '=',
                    'roles.id'
                )
                ->select('users.*')
                ->orderBy('roles.id')
                ->get();

            return Inertia::render('User/Index', [
                'users' => $users,
            ]);
        } else {
            //else redirect to dashboard
            return redirect('/dashboard');
        }
    }
    public function show(User $user)
    {
        $user = Auth::user()->load('roles', 'roles.permissions');

        //sum log hours for this quarter
        $hoursThisQuarter = Log::where('user_id', $user->id)
            ->whereBetween('date', [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()])
            ->sum('hours');

        //sum distance for this quarter
        $distanceThisQuarter = Log::where('user_id', $user->id)
            ->whereBetween('date', [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()])
            ->sum('distance');

        //sum travel_time for this quarter
        $travelTimeThisQuarter = Log::where('user_id', $user->id)
            ->whereBetween('date', [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()])
            ->sum('travel_time');

        $rate = getRatesFromRole($user->role)->rate;
        $travelRate = getRatesFromRole($user->role)->travelRate;
        $mileageRate = env('MILEAGE_RATE');

        //calculate eqiv hours for this quarter
        //round here, because svelte doesn't like decimals
        $equivHoursThisQuarter = round((($hoursThisQuarter * $rate) + ($distanceThisQuarter * $mileageRate) + ($travelTimeThisQuarter * $travelRate)) / $rate);


        // Get total hours for each working week, for the last 24 weeks
        $last24Weeks = Log::where('user_id', $user->id)
            ->whereBetween('date', [Carbon::now()->endOfWeek()->subWeeks(24), Carbon::now()->endOfWeek()])
            ->selectRaw('sum(hours) as hours, sum(distance) as distance, sum(travel_time) as travel_time, week(date) as week, MIN(date) as start_date')
            ->groupBy('week')
            ->get()
            ->map(function ($item) use ($rate, $mileageRate, $travelRate) {
                $item->total = (($item->hours * $rate) + ($item->distance * $mileageRate) + ($item->travel_time * $travelRate)) / $rate;
                $item->start_date = Carbon::parse($item->start_date)->startOfWeek()->toDateString();
                return $item;
            });


        $emptyWeeks = collect([]);

        // Create an array of empty weeks
        for ($i = 23; $i >= 0; $i--) {
            $emptyWeeks->push((object)[
                'hours' => 0,
                'distance' => 0,
                'travel_time' => 0,
                'week' => Carbon::now()->endOfWeek()->subWeeks($i)->weekOfYear,
                'start_date' => Carbon::now()->endOfWeek()->subWeeks($i)->startOfWeek()->toDateString(),
                'total' => 0,
            ]);
        }

        // Merge existing weeks with empty weeks
        $mergedWeeks = $emptyWeeks->map(function ($emptyWeek) use ($last24Weeks) {
            $existingWeek = $last24Weeks->firstWhere('week', $emptyWeek->week);

            return $existingWeek ?: (object) $emptyWeek;
        });

        // $mergedWeeks = $mergedWeeks->sortBy('start_date');

        // Calculate the 12-week rolling average for the last 12 weeks
        $rollingAverages = [];
        for ($i = 12; $i <= 23; $i++) {
            $sum = 0;

            for ($j = $i - 11; $j <= $i; $j++) {

                $sum += $mergedWeeks[$j]->total;
            }

            $rollingAverages[] = [
                'week' => $mergedWeeks[$i]->week,
                'average' => $sum / 12,
            ];
        }

        $rollingAverages = collect($rollingAverages);

        //get percentage of equivalent hours compared to user->target
        $percentEquivHoursThisQuarter = round($equivHoursThisQuarter / $user->target * 100);

        //get percentage of time through current quarter
        $quarterStart = Carbon::now()->startOfQuarter();
        $quarterEnd = Carbon::now()->endOfQuarter();
        $quarterLength = $quarterStart->diffInDays($quarterEnd);
        $daysIntoQuarter = Carbon::now()->diffInDays($quarterStart);
        $percentOfQuarter = round($daysIntoQuarter / $quarterLength * 100);

        //milesthismonth
        $milesThisMonth = Log::where('user_id', $user->id)
            ->whereMonth('date', date('m'))
            ->sum('distance');

        //mileslastmonth
        $milesLastMonth = Log::where('user_id', $user->id)
            ->whereMonth('date', date('m') - 1)
            ->sum('distance');

        //totalmiles
        $totalMiles = Log::where('user_id', $user->id)
            ->sum('distance');


        //count how many clients where status is not inactive
        $clientCount = Client::where('user_id', $user->id)
            ->where('client_status', '!=', 'inactive')
            ->count();

        return Inertia::render('User/Profile', [
            'user' => $user,
            'milesThisMonth' => $milesThisMonth,
            'milesLastMonth' => $milesLastMonth,
            'totalMiles' => $totalMiles,
            'equivHoursThisQuarter' => $equivHoursThisQuarter,
            'userTarget' => $user->target,
            'percentEquivHoursThisQuarter' => $percentEquivHoursThisQuarter,
            'percentOfQuarter' => $percentOfQuarter,
            'clientCount' => $clientCount,
            'last12Weeks' => $mergedWeeks,
            'rollingAverages' => $rollingAverages,

        ]);
    }
    public function editRolesAndPermissions($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all();
        $userRoles = $user->roles->pluck('name')->toArray();
        $userPermissions = $user->permissions->pluck('name')->toArray();

        return Inertia::render('User/RolesPermissions', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'userRoles' => $userRoles,
            'userPermissions' => $userPermissions
        ]);
    }
    public function assignRole(User $user, Role $role)
    {
        $user->assignRole($role);

        // Return updated user data
        $user->refresh();
        $userRoles = $user->roles->pluck('name');
        $userPermissions = $user->permissions->pluck('name');

        return Inertia::render('UserRolesPermissions', [
            'user' => $user,
            'roles' => Role::all(),
            'permissions' => Permission::all(),
            'userRoles' => $userRoles,
            'userPermissions' => $userPermissions
        ]);
    }

    public function removeRole(User $user, Role $role)
    {
        $user->removeRole($role);

        // Return updated user data
        $user->refresh();
        $userRoles = $user->roles->pluck('name');
        $userPermissions = $user->permissions->pluck('name');

        return Inertia::render('UserRolesPermissions', [
            'user' => $user,
            'roles' => Role::all(),
            'permissions' => Permission::all(),
            'userRoles' => $userRoles,
            'userPermissions' => $userPermissions
        ]);
    }

    public function givePermission(User $user, Permission $permission)
    {
        $user->givePermissionTo($permission);

        // Return updated user data
        $user->refresh();
        $userRoles = $user->roles->pluck('name');
        $userPermissions = $user->permissions->pluck('name');

        return Inertia::render('UserRolesPermissions', [
            'user' => $user,
            'roles' => Role::all(),
            'permissions' => Permission::all(),
            'userRoles' => $userRoles,
            'userPermissions' => $userPermissions
        ]);
    }

    public function revokePermission(User $user, Permission $permission)
    {
        $user->revokePermissionTo($permission);

        // Return updated user data
        $user->refresh();
        $userRoles = $user->roles->pluck('name');
        $userPermissions = $user->permissions->pluck('name');

        return Inertia::render('UserRolesPermissions', [
            'user' => $user,
            'roles' => Role::all(),
            'permissions' => Permission::all(),
            'userRoles' => $userRoles,
            'userPermissions' => $userPermissions
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Auth;
use App\Models\Log;
use Carbon\Carbon;
use App\Models\Client;

class UserController extends Controller
{

    public function show(User $user)
    {
        $user=Auth::user();

        //sum log hours for this quarter
        $hoursThisQuarter=Log::where('user_id', $user->id)
            ->whereBetween('date', [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()])
            ->sum('hours');
        
        //sum distance for this quarter
        $distanceThisQuarter=Log::where('user_id', $user->id)
            ->whereBetween('date', [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()])
            ->sum('distance');
        
        //sum travel_time for this quarter
        $travelTimeThisQuarter=Log::where('user_id', $user->id)
            ->whereBetween('date', [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()])
            ->sum('travel_time');

        $rate = getRatesFromRole($user->role)->rate;
        $travelRate = getRatesFromRole($user->role)->travelRate;

        //calculate earnings for this quarter
        $equivHoursThisQuarter=(($hoursThisQuarter*$rate)+($distanceThisQuarter*env('MILEAGE_RATE'))+($travelTimeThisQuarter*$travelRate))/$rate;

        //get percentage of equivalent hours compared to user->target
        $percentEquivHoursThisQuarter=round($equivHoursThisQuarter/$user->target*100);

        //get percentage of time through current quarter
        $quarterStart=Carbon::now()->startOfQuarter();
        $quarterEnd=Carbon::now()->endOfQuarter();
        $quarterLength=$quarterStart->diffInDays($quarterEnd);
        $daysIntoQuarter=Carbon::now()->diffInDays($quarterStart);
        $percentOfQuarter=round($daysIntoQuarter/$quarterLength*100);

        //milesthismonth
        $milesThisMonth=Log::where('user_id', $user->id)
            ->whereMonth('date', date('m'))
            ->sum('distance');

        //mileslastmonth
        $milesLastMonth=Log::where('user_id', $user->id)
            ->whereMonth('date', date('m')-1)
            ->sum('distance');

          //totalmiles
        $totalMiles=Log::where('user_id', $user->id)
            ->sum('distance');


        //count how many clients where status is not inactive
        $clientCount=Client::where('user_id', $user->id)
            ->where('client_status', '!=', 'inactive')
            ->count();

        return Inertia::render('User/Show', [
          'user' => $user,
          'milesThisMonth' => $milesThisMonth,
          'milesLastMonth' => $milesLastMonth,
          'totalMiles' => $totalMiles,
          'equivHoursThisQuarter' => $equivHoursThisQuarter,
          'userTarget' => $user->target,
          'percentEquivHoursThisQuarter' => $percentEquivHoursThisQuarter,
          'percentOfQuarter' => $percentOfQuarter,
          'clientCount' => $clientCount,

        ]);
    }
}
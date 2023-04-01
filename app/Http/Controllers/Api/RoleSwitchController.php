<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class RoleSwitchController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->hasRole('Super Admin'), 403);

        $roles = Role::all();
        $selectedRole = Session::get('view_as_role') ?: Auth::user()->getRoleNames()[0];

        return Inertia::render('RoleSwitch', [
            'roles' => $roles,
            'selectedRole' => $selectedRole,
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->hasRole('Super Admin'), 403);

        $role = $request->input('role');

        if ($role === 'Super Admin') {
            Session::forget('view_as_role');
        } else {
            Session::put('view_as_role', $role);
        }

        // $redirectUrl = route('profile');
        // if ($request->routeIs('profile')) {
        //     $redirectUrl = route('dashboard');
        // }

        $request->session()->flash('success', 'Role switched to ' . $role);

        return response()->json([
            'redirect' => env("APP_URL") . '/dashboard',
        ]);
    }
}

<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Api\RoleSwitchController;

// home route
Route::get('/', function () {

    //if auth redirect to dashboard
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    //else render welcome page
    return Inertia::render('Welcome');
})->name('welcome');

// auth routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/callback', [AuthController::class, 'callback']);
Route::get('/logout', [AuthController::class, 'logout']);

// all other routes require middleware auth group
Route::middleware('auth')->group(function () {

    // dashboard route
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'show'])->name('profile');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::get('/users/{id}/roles-permissions', [UserController::class, 'editRolesAndPermissions'])->name('users.edit-roles-permissions');
    Route::post('/users/{user}/assign-role/{role}', [UserController::class, 'assignRole'])->name('users.assign-role');
    Route::post('/users/{user}/remove-role/{role}', [UserController::class, 'removeRole'])->name('users.remove-role');
    Route::post('/users/{user}/give-permission/{permission}', [UserController::class, 'givePermission'])->name('users.give-permission');
    Route::post('/users/{user}/revoke-permission/{permission}', [UserController::class, 'revokePermission'])->name('users.revoke-permission');

    Route::get('/role-switch', [RoleSwitchController::class, 'index'])->name('role-switch');
});

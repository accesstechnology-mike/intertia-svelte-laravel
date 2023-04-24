<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Api\RoleSwitchController;
use App\Http\Controllers\ASPController;


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

    // // dashboard route
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'show'])->name('profile');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Route::get('/users/{id}/roles-permissions', [UserController::class, 'editRolesAndPermissions'])->name('users.edit-roles-permissions');
    // Route::post('/users/{user}/assign-role/{role}', [UserController::class, 'assignRole'])->name('users.assign-role');
    // Route::post('/users/{user}/remove-role/{role}', [UserController::class, 'removeRole'])->name('users.remove-role');
    // Route::post('/users/{user}/give-permission/{permission}', [UserController::class, 'givePermission'])->name('users.give-permission');
    // Route::post('/users/{user}/revoke-permission/{permission}', [UserController::class, 'revokePermission'])->name('users.revoke-permission');

    Route::get('/role-switch', [RoleSwitchController::class, 'index'])->name('role-switch');

    Route::get('/leave-requests', function () {
        return Inertia::render('User/LeaveRequests');
    })->name('leave-requests');

    Route::get('/leave-types', function () {
        return Inertia::render('User/LeaveTypes');
    })->name('leave-types');

    Route::get('/holidays', function () {
        return Inertia::render('User/Holidays');
    })->name('holidays');
});

Route::middleware(['auth', 'role:Admin|Super Admin'])
    ->prefix('asp')
    ->group(function () {
        Route::get('/', [ASPController::class, 'index'])->name('asp.index');
        Route::get('/create', [ASPController::class, 'create'])->name('asp.create');
        Route::post('/', [ASPController::class, 'store'])->name('asp.store');
        Route::get('/{entry}/edit', [ASPController::class, 'edit'])->name('asp.edit');
        Route::put('/{entry}', [ASPController::class, 'update'])->name('asp.update');
        Route::delete('/{entry}', [ASPController::class, 'destroy'])->name('asp.destroy');
    });

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



Route::any('{any}', function () {
    return redirect('https://log3.vercel.app');
})->where('any', '.*');

// // home route
// Route::get('/', function () {

    //if auth redirect to dashboard
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    //else render welcome page
    return Inertia::render('Welcome');
})->name('welcome');

// // auth routes
// Route::get('/login', [AuthController::class, 'login'])->name('login');
// Route::get('/callback', [AuthController::class, 'callback']);
// Route::get('/logout', [AuthController::class, 'logout']);

// // all other routes require middleware auth group
// Route::middleware('auth')->group(function () {

    // dashboard route
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'show'])->name('profile');
});

<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;

// home route
Route::get('/', function () {return Inertia::render('Home');});

// auth routes
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/callback', [AuthController::class, 'callback']);
Route::get('/logout', [AuthController::class, 'logout']);

// all other routes require middleware auth group
Route::middleware('auth')->group(function () {

    // dashboard route
    Route::get('/dashboard', [UserController::class, 'show'])->name('dashboard');

});

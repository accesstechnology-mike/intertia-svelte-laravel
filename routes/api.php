<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\RoleSwitchController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth'])->group(function () {
    //dashboard
    Route::get('/clients', [ClientController::class, 'index']);
    Route::patch('/clients/{client}', [ClientController::class, 'updateStatus']);
    //permissions
    Route::get('/permissions', [PermissionController::class, 'index']);
    Route::post('/permissions', [PermissionController::class, 'store']);
    //roleswitch
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/role-switch', [RoleSwitchController::class, 'store']);
});

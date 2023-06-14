<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication Routes
Route::controller(AuthenticationController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

// Admin Routes
Route::group(['middleware' => ['api', 'role:admin', 'auth:api']], function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('return-admin', 'user');
    });
});

// User Routes
Route::group(['middleware' => ['api', 'role:user', 'auth:api']], function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('return-user', 'user');
    });
});



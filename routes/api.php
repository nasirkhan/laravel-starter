<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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


Route::group(['prefix' => 'v1'], function () {
    Route::post('/login',               [AuthController::class, 'login']);
    Route::post('/register',            [AuthController::class, 'register']);
    Route::post('send-otp',             [AuthController::class, 'sendOtp']);
    Route::post('verify-otp',           [AuthController::class, 'verifyOtp']);
    Route::post('forgot-password',      [AuthController::class, 'forgetPassword']);
    Route::post('reset-password',       [AuthController::class, 'resetPassword']);



    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/change-password',        [AuthController::class, 'changePassword']);
        Route::get('/profile',                 [AuthController::class, 'profile']);
        Route::post('/profile-update',         [AuthController::class, 'profileUpdate']);
    });
});

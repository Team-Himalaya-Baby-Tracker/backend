<?php

use App\Actions\Auth\ResetPassword;
use App\Actions\Auth\SendResetPasswordCode;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BabiesController;
use App\Http\Controllers\MeController;
use Illuminate\Support\Facades\Route;

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
Route::post('login', [AuthController::class, 'login']);
Route::post('signup', [AuthController::class, 'signup']);
Route::post('forgot-password', SendResetPasswordCode::class)->middleware('guest');
Route::post('reset-password', ResetPassword::class)->middleware('guest');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('me', [MeController::class, 'me']);
    Route::group(['prefix' => 'babies'] , function () {
        Route::get('' , [BabiesController::class , 'index']);
    });
});

<?php

use App\Actions\Auth\ResetPassword;
use App\Actions\Auth\SendResetPasswordCode;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BabiesController;
use App\Http\Controllers\BabySitterController;
use App\Http\Controllers\BabySizeController;
use App\Http\Controllers\BabyWeightController;
use App\Http\Controllers\BottleFeedController;
use App\Http\Controllers\BreastFeedRecordController;
use App\Http\Controllers\DiaperDataController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\PartnerController;
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
    Route::put('me', [MeController::class, 'update']);
    Route::group(['prefix'=>'my-baby-sitter-invitations'], function () {
        Route::get('/', [ParentController::class, 'myBabySitterInvitations']);
        Route::put('/{invitation}', [ParentController::class, 'updateBabySitterInvitation']);
    });

    Route::get('babies', [BabiesController::class, 'index']);
    Route::post('babies', [BabiesController::class, 'store'])->middleware(['is-parent', 'attach-creator']);
    Route::get('babies/{baby}', [BabiesController::class, 'show']);
    Route::put('babies/{baby}', [BabiesController::class, 'update']);
    Route::delete('babies/{baby}', [BabiesController::class, 'destroy'])->middleware('is-parent');

    Route::group(['prefix' => 'babies', 'middleware' => 'my-baby'], function () {
        //*************
        Route::middleware('baby-sitter-access')->group(function () {
            Route::get('{baby}/diapers', [DiaperDataController::class, 'index']);
            Route::post('{baby}/diapers', [DiaperDataController::class, 'store'])->middleware('attach-creator');
            Route::get('{baby}/sizes', [BabySizeController::class, 'index']);
            Route::post('{baby}/sizes', [BabySizeController::class, 'store'])->middleware('attach-creator');
            Route::get('{baby}/weights', [BabyWeightController::class, 'index']);
            Route::post('{baby}/weights', [BabyWeightController::class, 'store'])->middleware('attach-creator');

            Route::get('{baby}/breast-feed', [BreastFeedRecordController::class, 'index']);
            Route::post('{baby}/breast-feed', [BreastFeedRecordController::class, 'store'])->middleware('attach-creator');

            Route::get('{baby}/bottle-feed', [BottleFeedController::class, 'index']);
            Route::post('{baby}/bottle-feed', [BottleFeedController::class, 'store'])->middleware('attach-creator');
        });
    });
    Route::group(['prefix' => 'invitations', 'middleware' => 'is-parent'], function () {
        Route::get('sent', [PartnerController::class, 'showSentInvitations']);
        Route::get('received', [PartnerController::class, 'showReceivedInvitations']);
        Route::post('send', [PartnerController::class, 'sendInvitation']);
        Route::put('{invitation}', [PartnerController::class, 'respondToInvitation']);
    });

    // create routes for baby sitter
    Route::group(['prefix' => 'baby-sitter'], function () {
        Route::get('', [BabySitterController::class, 'index'])->name('babysitter.index');
        Route::post('invite', [BabySitterController::class, 'invite'])->name('babysitter.invite');
        Route::post('{babySitter}/terminate', [BabySitterController::class, 'terminate'])->name('babysitter.terminate')->middleware('is-parent');
        Route::group(['prefix' => 'invitations'], function () {
            Route::get('list', [BabySitterController::class, 'listInvitations'])->name('babysitter.invitations.list');
            Route::put('{invitation}', [BabySitterController::class, 'respondToInvitation'])->name('babysitter.invitations.respond');
        });

        Route::post('{babySitter}/rate', [BabySitterController::class, 'rate'])->name('babysitter.rate')->middleware('is-parent');
    });
});

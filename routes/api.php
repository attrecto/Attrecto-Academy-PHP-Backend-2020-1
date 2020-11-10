<?php

use App\Http\Controllers\BadgeController;
use App\Http\Controllers\UserController;
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

Route::prefix('users')->group(function () {
    Route::post('/', [UserController::class, 'store']);
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{user}', [UserController::class, 'show']);
    Route::put('/{user}', [UserController::class, 'update']);
    Route::delete('/{user}', [UserController::class, 'destroy']);
    Route::post('/{user}/badges/sync', [UserController::class, 'syncBadges']);
    Route::post('/{user}/badges', [UserController::class, 'addBadges']);
    Route::delete('/{user}/badges', [UserController::class, 'removeBadges']);
});

Route::prefix('badges')->group(function () {
    Route::post('/', [BadgeController::class, 'store']);
    Route::get('/', [BadgeController::class, 'index']);
    Route::get('/{badge}', [BadgeController::class, 'show']);
    Route::put('/{badge}', [BadgeController::class, 'update']);
    Route::delete('/{badge}', [BadgeController::class, 'destroy']);
});

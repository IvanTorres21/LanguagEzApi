<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BadgeController;
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

Route::post('/login',[UserController::class, 'login']);
Route::post('/signup', [UserController::class, 'signup']);
Route::get('/badges', [BadgeController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/user-badges', [BadgeController::class, 'userBadges']);
    Route::post('/store-badge', [BadgeController::class, 'store']);
    Route::post('/assign-badge', [BadgeController::class, 'assignBadge']);

    Route::post('/get-friends', [UserController::class, 'getFriends']);
    Route::post('/add-friend', [UserController::class, 'addFriend']);
});
<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\BadgeController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\DictionaryController;
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
Route::get('/countries', [CountryController::class, 'index']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/languages', [LanguageController::class, 'index']);
    Route::post('/user_badges', [BadgeController::class, 'userBadges']);
    Route::post('/store_badge', [BadgeController::class, 'store']);
    Route::post('/update_badge', [BadgeController::class, 'update']);
    Route::post('/assign_badge', [BadgeController::class, 'assignBadge']);

    Route::post('/get_friends', [UserController::class, 'getFriends']);
    Route::post('/add_friend', [UserController::class, 'addFriend']);

    Route::post('/store_language', [LanguageController::class, 'store']);
    Route::post('/update_language', [LanguageController::class, 'update']);
    Route::get('/get_language/{id}', [LanguageController::Class, 'getLanguage']);
    Route::post('/get_language_lessons', [LanguageController::class, 'getLessons']);
    Route::post('/assign_language', [LanguageController::class, 'assignLanguage']);
    Route::post('/delete_language', [LanguageController::class, 'deleteLanguage']);

    Route::get('/get_notifications', [NotificationController::class, 'index']);
    Route::post('/store_notification', [NotificationController::class, 'store']);
    Route::post('/update_notification', [NotificationController::class, 'update']);
    Route::post('/delete_notification', [NotificationController::class, 'delete']);

    Route::post('/get_lessons', [LessonController::class, 'index']);
    Route::post('/store_lesson', [LessonController::class, 'store']);
    Route::get('/get_lesson/{id}', [LessonController::class, 'getLesson']);
    Route::post('/update_lesson', [LessonController::class, 'update']);
    Route::post('/delete_lesson', [LessonController::class, 'delete']);
    Route::post('/mark_lesson', [LessonController::class, 'markLessonAsDone']);

    Route::post('/get_tests', [TestController::class, 'index']);
    Route::post('/store_test', [TestController::class, 'store']);
    Route::get('/get_test/{id}', [TestController::class, 'getTest']);
    Route::post('/update_test', [TestController::class, 'update']);
    Route::post('/delete_test', [TestController::class, 'delete']);
    Route::post('/mark_test', [TestController::class, 'markTestAsDone']);

    Route::post('/dictionary', [DictionaryController::class, 'index']);
    Route::post('/store_word', [DictionaryController::class, 'store']);
    Route::get('/getWord/{id}', [DictionaryController::class, 'getWord']);
    Route::post('/update_word', [DictionaryController::class, 'update']);
    Route::post('/delete_word', [DictionaryController::class, 'destroy']);
    
    Route::post('/store_country', [CountryController::class, 'store']);
    Route::post('/delete_country', [CountryController::class, 'delete']);
});
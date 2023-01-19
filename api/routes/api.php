<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HobbyCategoryController;
use App\Http\Controllers\API\HobbyController;
use App\Http\Controllers\API\UserHobbyController;
use Illuminate\Http\Request;
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
Route::group(['prefix' => 'auth'], static function () {
    Route::post('login', [ AuthController::class, 'login']);
    Route::post('register', [ AuthController::class, 'register']);
    Route::get('user', [ AuthController::class, 'user'])->middleware('auth:sanctum');
    Route::post('logout', [ AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::group(['middleware' => 'auth:sanctum'], static function () {
    Route::apiResource('hobby', HobbyController::class)->except(['update']);
    Route::post('hobby/{hobby_id}/update', [HobbyController::class,'update']);

    Route::apiResource('hobby-category', HobbyCategoryController::class)->except(['update']);
    Route::post('hobby-category/{hobby_category_id}/update', [HobbyCategoryController::class,'update']);

    Route::post('user-hobby/attach',[UserHobbyController::class,'attach']);
    Route::post('user-hobby/detach',[UserHobbyController::class,'detach']);
    Route::post('user-hobby/sync',[UserHobbyController::class,'sync']);

});



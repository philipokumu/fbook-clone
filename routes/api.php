<?php

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


Route::middleware('auth:api')->group(function () {

    Route::get('auth-user', [App\Http\Controllers\AuthUserController::class, 'show']);

    Route::apiResources([
        '/posts' => App\Http\Controllers\PostController::class,
        '/posts/{post}/like' => App\Http\Controllers\PostLikeController::class,
        '/users' => App\Http\Controllers\UserController::class,
        '/users/{user}/posts' => App\Http\Controllers\UserPostController::class,
        '/friend-request' => App\Http\Controllers\FriendRequestController::class,
        '/friend-request-response' => App\Http\Controllers\FriendRequestResponseController::class,
    ]);

});

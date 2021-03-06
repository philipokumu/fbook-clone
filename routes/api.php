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

    //text chat route
    Route::post('send', [App\Http\Controllers\ChatController::class, 'send']);

    // Endpoints to call or receive calls.
    Route::post('/video/call-user', 'App\Http\Controllers\VideoChatController@callUser');
    Route::post('/video/accept-call', 'App\Http\Controllers\VideoChatController@acceptCall');

    Route::apiResources([
        '/posts' => App\Http\Controllers\PostController::class,
        '/posts/{post}/like' => App\Http\Controllers\PostLikeController::class,
        '/posts/{post}/comment' => App\Http\Controllers\PostCommentController::class,
        '/users' => App\Http\Controllers\UserController::class,
        '/users/{user}/posts' => App\Http\Controllers\UserPostController::class,
        '/friend-request' => App\Http\Controllers\FriendRequestController::class,
        '/friend-request-response' => App\Http\Controllers\FriendRequestResponseController::class,
        '/user-images' => App\Http\Controllers\UserImageController::class,
    ]);

});

<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Auth::routes();
// Route::get('chat', [App\Http\Controllers\ChatController::class, 'chat']);
Route::post('send', [App\Http\Controllers\ChatController::class, 'send']);

Route::get('{any}', [App\Http\Controllers\AppController::class, 'index'])
    ->where('any','.*')
    ->middleware('auth')
    ->name('home');

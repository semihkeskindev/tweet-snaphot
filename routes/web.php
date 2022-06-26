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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/', [\App\Http\Controllers\HomeController::class, 'searchTweet'])->middleware('auth');

Route::get('/tweet/{tweet:tweet_id}', [\App\Http\Controllers\TwitterController::class, 'show'])->name('tweets.show');

Route::group(['middleware' => 'auth', 'prefix' => 'profile'], function () {
    Route::get('son-kaydettiklerim', [\App\Http\Controllers\Profile\TwitterController::class, 'lastSavedTweets'])->name('profile.lastSavedTweets');
});

Auth::routes();


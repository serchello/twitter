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

Route::get('/', function () {return view('welcome');});

Auth::routes();

// Route::get('/profile', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {

    Route::get('postTweet', function () { \LogActivity::addToLog(); return view('pages.post_tweet'); })->name('postTweet');
    Route::post('addTweet', [App\Http\Controllers\UserController::class, 'addTweet'], function (Request $request){ } )->name('tweet');
	Route::get('/profile/{username}', [App\Http\Controllers\UserController::class, 'getUser'], function ($username) {});
    Route::get('timeline', [App\Http\Controllers\UserController::class, 'timeline'], function () {});
	Route::get('userslist', [App\Http\Controllers\UserController::class, 'usersList'], function () {});
	Route::post('followUnfollow', [App\Http\Controllers\UserController::class, 'followUnfollow'], function (Request $request){} )->name('followUnfollow');

});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profileEdit', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
});

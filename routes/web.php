<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Laravel Socialite Facebook, Twitter, GitHub, etc
Route::get('auth/{driver}', ['as' => 'socialAuth', 'uses' => 'Auth\SocialController@redirectToProvider']);
Route::get('auth/{driver}/callback', ['as' => 'socialAuthCallback', 'uses' => 'Auth\SocialController@handleProviderCallback']);

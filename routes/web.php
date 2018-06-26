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

Route::view('/', 'welcome');

Auth::routes();

Route::middleware('auth')->namespace('Site')->prefix('sites')->group(function () {
    Route::get('add', 'SocialiteController@redirect')->name('sites.redirect');
    Route::get('list', 'SocialiteController@callback')->name('sites.callback');

    Route::post('create', 'CreateController')->name('sites.create');

    Route::any('/{site}', 'ShowController')->name('sites.show');

    Route::post('/{site}/memo/{memo}', 'MemoController')->name('sites.memo');

    Route::get('/{site}/edit', 'EditController@edit')->name('sites.edit');
    Route::put('/{site}', 'EditController@update')->name('sites.update');
    Route::put('/{site}/password', 'PasswordController')->name('sites.password');

    Route::get('/{site}/hide', 'HideController')->name('sites.hide');
});

Route::prefix('share')->group(function () {
    Route::match(['get', 'post'], '/{site}', 'ShareController@show')->where('id', '[0-9]+')->name('share.show');
    Route::post('/{site}/memo/{memo}', 'ShareController@memo')->name('share.memo');
    Route::get('/login/{site}', 'ShareController@form')->name('share.form');
    Route::post('/login/{site}', 'ShareController@login')->name('share.login');
});


Route::get('/home', 'HomeController')->name('home');

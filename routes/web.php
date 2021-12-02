<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
/*--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------*/
Route::get('/','IndexController@index')->name('index');
/*--------------------------------------------------------------------------
| SIGNUP & SIGNIN
|--------------------------------------------------------------------------*/
Route::any('/register','UserController@register')->name('register');
Route::any('/login','UserController@login')->name('login');
/*--------------------------------------------------------------------------
| USE LARAVEL DEFAULT AUTH GUARD
|--------------------------------------------------------------------------*/
Route::group(['middleware' => ['auth']], function () {

    Route::get('/logout','UserController@logout')->name('logout');
    Route::get('/dating','UserController@dating')->name('dating');
    Route::match(['get','post'],'/dating/image-upload','UserController@imageUp')->name('image-up');
    Route::post('update-like-status', 'UserController@updateLikeStatus');

});


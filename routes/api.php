<?php

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Api\AuthApiController@login')->name('api.auth.login');
    Route::post('signup', 'Api\AuthApiController@signUp')->name('api.auth.signUp');

    Route::group(['middleware' =>  ['auth:api']], function() {
        Route::get('logout', 'Api\AuthApiController@logout')->name('api.auth.logout');
        Route::get('user', 'Api\AuthApiController@user')->name('api.auth.user');
    });
});

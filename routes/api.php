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

Route::middleware(['auth:api'])->name('api.')->group(function() {

    // Ingredients
    Route::prefix('ingredients')->name('ingredients.')->group(function () {
        Route::get('/', 'Api\IngredientApiController@index')->name('index');
        Route::post('/store', 'Api\IngredientApiController@store')->name('store');
        Route::get('/{id}/show', 'Api\IngredientApiController@show')->name('show');
        Route::put('/{id}/update', 'Api\IngredientApiController@update')->name('update');
        Route::delete('/{id}/destroy', 'Api\IngredientApiController@destroy')->name('destroy');
    });

    // Pizzas
    Route::prefix('pizzas')->name('pizzas.')->group(function () {
        Route::get('/', 'Api\PizzaApiController@index')->name('index')->withoutMiddleware(['auth:api']);
        Route::post('/store', 'Api\PizzaApiController@store')->name('store');
        Route::get('/{id}/show', 'Api\PizzaApiController@show')->name('show');
        Route::put('/{id}/update', 'Api\PizzaApiController@update')->name('update');
        Route::delete('/{id}/destroy', 'Api\PizzaApiController@destroy')->name('destroy');
    });

    // Order
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', 'Api\OrderApiController@index')->name('index');
        Route::post('/store', 'Api\OrderApiController@store')->name('store');
    });

});

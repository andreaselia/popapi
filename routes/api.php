<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => 'api'], function () {
    Route::group(['prefix' => 'collections'], function () {
        Route::get('/', 'ApiController@collections');
        Route::get('{collection}/{page?}', 'ApiController@collection');
    });

    Route::group(['prefix' => 'results'], function () {
        Route::get('/', 'ApiController@results');
        Route::get('{collection}/{sku}/{page?}', 'ApiController@result');
    });
});

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

Route::get('/', 'PageController@index');
Route::get('documentation', 'PageController@documentation');
Route::get('documentation/{page}', 'PageController@documentationPage');
Route::get('scrape/{collection}', 'TestController@scrape');

Route::get('test', 'TestController@index');

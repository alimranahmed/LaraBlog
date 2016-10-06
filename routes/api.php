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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/article', 'ArticleController@index');
Route::get('/article/{articleId}', 'ArticleController@show');
Route::put('/article/{articleId}', 'ArticleController@update');
Route::post('/article', 'ArticleController@store');

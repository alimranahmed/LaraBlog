<?php

//Article
Route::get('/', 'ArticleController@index')->name('home');
Route::get('article', 'ArticleController@index')->name('articles');
Route::get('article/{articleId}', 'ArticleController@show')->name('get-article');
Route::put('article/{articleId}', 'ArticleController@update');
Route::post('article', 'ArticleController@store');
Route::put('article/toggle-publish/{articleId}', 'ArticleController@togglePublish');

Route::get('search', 'ArticleController@search')->name('search-article');
//Comment
Route::post('comment/{articleId}', 'CommentController@store')->name('add-comment');

//Category
Route::get('category', 'CategoryController@index');
Route::get('category/{categoryId}', 'CategoryController@show');
Route::put('category/{categoryId}', 'CategoryController@update');
Route::post('category/{categoryId}', 'CategoryController@store');
Route::get('category/article/{categoryAlias}', 'CategoryController@getArticles')->name('articles-by-category');

//Admin
Route::get('admin/login', 'AuthController@showLoginForm')->name('loginForm');
Route::post('admin/login', 'AuthController@login')->name('login');
Route::get('admin/logout', 'AuthController@logout')->name('logout');
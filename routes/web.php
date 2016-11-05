<?php

//Article
Route::get('/', 'ArticleController@index')->name('home');
Route::get('article', 'ArticleController@index')->name('articles');
Route::get('article/{articleId}', 'ArticleController@show')->name('get-article');
Route::put('article/{articleId}', 'ArticleController@update');
Route::post('article', 'ArticleController@store');
Route::put('article/toggle-publish/{articleId}', 'ArticleController@togglePublish');

Route::get('search/{queryString}', 'ArticleController@search');
//Comment
Route::post('comment/{articleId}', 'CommentController@store')->name('add-comment');

//Category
Route::get('category', 'CategoryController@index');
Route::get('category/{categoryId}', 'CategoryController@show');
Route::put('category/{categoryId}', 'CategoryController@update');
Route::post('category/{categoryId}', 'CategoryController@store');
Route::get('category/article/{categoryAlias}', 'CategoryController@getArticles')->name('articles-by-category');
<?php

//Home
Route::get('/', 'HomeController@index')->name('home');
//Article
Route::get('article', 'ArticleController@index')->name('articles');
Route::get('article/{articleId}', 'ArticleController@show')->name('get-article');
Route::put('article/{articleId}', 'ArticleController@update');
Route::post('article', 'ArticleController@store')->name('add-article');
Route::put('article/toggle-publish/{articleId}', 'ArticleController@togglePublish')->name('article-toggle-publish');
Route::get('category/article/{categoryAlias}', 'CategoryController@getArticles')->name('articles-by-category');

Route::get('search', 'ArticleController@search')->name('search-article');
//Comment
Route::post('comment/{articleId}', 'CommentController@store')->name('add-comment');

//Category
Route::get('admin/category', 'CategoryController@index')->name('categories');
Route::get('category/{categoryId}', 'CategoryController@show')->name('get-category');
Route::put('category/{categoryId}', 'CategoryController@update')->name('update-category');
Route::post('category/{categoryId}', 'CategoryController@store')->name('add-category');

//Admin
Route::get('admin/login', 'AuthController@showLoginForm')->name('loginForm');
Route::post('admin/login', 'AuthController@login')->name('login');
Route::get('admin/logout', 'AuthController@logout')->name('logout');
Route::get('admin/dashboard', 'DashboardController@index')->name('admin-dashboard');

//admin articles
Route::get('admin/article', 'ArticleController@adminArticle')->name('admin-articles');
Route::get('admin/article/toggle-publish/{articleID}', 'ArticleController@togglePublish')->name('toggle-article-publish');

//Admin comments
Route::get('admin/comment', 'CommentController@index')->name('comments');
Route::get('admin/comment/toggle-publish/{commentId}', 'CommentController@togglePublish')->name('toggle-comment-publish');

//Admin users
Route::get('admin/user', 'UserController@index')->name('users');

//Admin keywords
Route::get('admin/keywords', 'KeywordController@index')->name('keywords');
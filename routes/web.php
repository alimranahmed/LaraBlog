<?php

use Illuminate\Support\Facades\Route;

//Home
Route::get('/', 'HomeController@index')->name('home');

//Subscribe
Route::get('subscription/confirm', 'SubscriptionController@confirm')->name('subscription.confirm');
Route::get('unsubscribe', 'SubscriptionController@unsubscribe')->name('unsubscribe');

//feedback
Route::view('contact', 'frontend.contact.create')->name('contact');

//Article
Route::get('article', 'ArticleController@index')->name('articles');
Route::get('article/{articleId}/{articleHeading?}', 'ArticleController@show')->name('get-article');
Route::get('category/article/{categoryAlias}', 'CategoryController@getArticles')->name('articles-by-category');
Route::get('keyword/article/{keywordName}', 'KeywordController@getArticles')->name('articles-by-keyword');
Route::get('search', 'ArticleController@search')->name('search-article');

//Comment
Route::post('comment/{articleId}', 'CommentController@store')->name('add-comment');
Route::get('comment/{commentId}/confirm', 'CommentController@confirmComment')->name('confirm-comment');

//Category
Route::get('category/{categoryId}', 'CategoryController@show')->name('get-category');

Route::view('pages/about', 'frontend.pages.about')->name('page.about');

//Admin auth
Route::get('admin/login', 'AuthController@showLoginForm')->name('login-form');
Route::post('admin/login', 'AuthController@login')->name('login');
Route::get('admin/logout', 'AuthController@logout')->name('logout');


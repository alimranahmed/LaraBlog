<?php

use App\Http\Controllers\CommentController;

Route::group(['middleware' => ['auth', 'role:owner|admin|author']], function () {
    //profile
    Route::get('profile', 'UserController@profile')->name('user-profile');
    //dashboard
    Route::get('dashboard', 'DashboardController@index')->name('admin-dashboard');
    //admin articles
    Route::get('article', 'ArticleController@adminArticles')->name('admin-articles');
    Route::get('article/toggle-publish/{articleID}', 'ArticleController@togglePublish')
        ->name('toggle-article-publish');
    Route::get('article/{articleId}/delete', 'ArticleController@destroy')->name('delete-article');
    Route::get('article/create', 'ArticleController@create')->name('create-article');
    Route::post('article', 'ArticleController@store')->name('store-article');
    Route::get('article/{articleId}/edit', 'ArticleController@edit')->name('edit-article');
    Route::put('article/{articleId}', 'ArticleController@update')->name('update-article');

    //Admin comments
    Route::get('comment', [CommentController::class, 'index'])->name('backend.comment.index');
    Route::get('comment/{comment}/edit', [CommentController::class, 'edit'])->name('backend.comment.edit');
    Route::get('comment/{comment}', [CommentController::class, 'show'])->name('backend.comment.show');

    //Admin feedback
    Route::get('feedback', 'FeedbackController@index')->name('feedbacks');
    Route::get('feedback/toggle-resolved/{feedbackId}', 'FeedbackController@toggleResolved')
        ->name('toggle-feedback-resolved');
    Route::get('feedback/close/{feedbackId}', 'FeedbackController@close')->name('close-feedback');
});

Route::group(['middleware' => ['auth', 'role:owner|admin']], function () {
    //admin category
    Route::get('category', 'CategoryController@index')->name('categories');
    Route::get('category/toggle-active/{categoryId}', 'CategoryController@toggleActive')
        ->name('toggle-category-active');
    Route::put('category/{categoryId}', 'CategoryController@update')->name('update-category');
    Route::post('category', 'CategoryController@store')->name('add-category');
    Route::get('category/{categoryId}/delete', 'CategoryController@destroy')->name('delete-category');

    //Admin users
    Route::get('user', 'UserController@index')->name('users');
    Route::get('user/{userId}/show', 'UserController@show')->name('get-user');
    Route::get('user/{userId}/delete', 'UserController@destroy')->name('delete-user');
    Route::put('user/change-password', 'UserController@changePassword')->name('change-password');
    Route::get('user/create', 'UserController@create')->name('create-user');
    Route::post('user/create', 'UserController@store')->name('store-user');
    Route::get('user/{userId}/edit', 'UserController@edit')->name('edit-user');
    Route::put('user/{userId}/update', 'UserController@update')->name('update-user');
    Route::get('user/toggle-active/{userId}', 'UserController@toggleActive')->name('toggle-user-active');

    //Admin keywords
    Route::post('keyword', 'KeywordController@store')->name('add-keyword');
    Route::get('keyword', 'KeywordController@index')->name('keywords');
    Route::get('keyword/toggle-active/{keywordId}', 'KeywordController@toggleActive')
        ->name('toggle-keyword-active');
    Route::put('keyword/{keywordId}', 'KeywordController@update')->name('update-keyword');
    Route::get('keyword/{keywordId}/delete', 'KeywordController@destroy')->name('delete-keyword');
});

Route::group(['middleware' => ['auth', 'role:owner']], function () {
    //admin config
    Route::get('config', 'ConfigController@index')->name('configs');
    Route::put('config/{configId}', 'ConfigController@update')->name('update-config');
});

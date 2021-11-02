<?php

use App\Http\Controllers\Backend\ArticleController;
use App\Http\Controllers\Backend\SubscriberController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\UserController;

Route::group(['middleware' => ['auth', 'role:owner|admin|author']], function () {
    //profile
    Route::get('profile', [UserController::class, 'profile'])->name('user-profile');
    //dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin-dashboard');

    //admin articles
    Route::get('article', [ArticleController::class, 'index'])->name('backend.article.index');
    Route::get('article/create', [ArticleController::class, 'create'])->name('backend.article.create');
    Route::get('article/{article}/edit', [ArticleController::class, 'edit'])->name('backend.article.edit');

    //Admin comments
    Route::get('comment', [CommentController::class, 'index'])->name('backend.comment.index');
    Route::get('comment/{comment}/edit', [CommentController::class, 'edit'])->name('backend.comment.edit');
    Route::get('comment/{comment}', [CommentController::class, 'show'])->name('backend.comment.show');

    Route::get('feedback', [FeedbackController::class, 'index'])->name('backend.feedback.index');

    Route::get('subscriber', [SubscriberController::class, 'index'])->name('backend.subscriber.index');
});

Route::group(['middleware' => ['auth', 'role:owner|admin']], function () {
    Route::get('category', [CategoryController::class, 'index'])->name('backend.category.index');

    //Admin users
    Route::get('user', [UserController::class, 'index'])->name('backend.user.index');
    Route::get('user/password/edit', [UserController::class, 'editPassword'])->name('backend.user.password.edit');
    Route::get('user/create', [UserController::class, 'create'])->name('backend.user.create');
    Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('backend.user.edit');

    Route::get('keyword', [KeywordController::class, 'index'])->name('backend.keyword.index');
});

Route::group(['middleware' => ['auth', 'role:owner']], function () {
    //admin config
    Route::get('config', [ConfigController::class, 'index'])->name('backend.config.index');
});

<?php

use App\Livewire\Backend\Dashboard;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'role:owner|admin|author']], function () {
    //profile
    Route::get('profile', \App\Livewire\Backend\User\Profile::class)->name('user-profile');

    //dashboard
    Route::get('dashboard', Dashboard::class)->name('admin-dashboard');

    //admin articles
    Route::get('article', \App\Livewire\Backend\Article\Index::class)->name('backend.article.index');
    Route::get('article/create', \App\Livewire\Backend\Article\Form::class)->name('backend.article.create');
    Route::get('article/{article}/edit', \App\Livewire\Backend\Article\Form::class)->name('backend.article.edit');

    //Admin comments
    Route::get('comment', \App\Livewire\Backend\Comment\Index::class)->name('backend.comment.index');
    Route::get('comment/{comment}/edit', \App\Livewire\Backend\Comment\Edit::class)->name('backend.comment.edit');
    Route::get('comment/{comment}', \App\Livewire\Backend\Comment\Show::class)->name('backend.comment.show');

    Route::get('feedback', \App\Livewire\Backend\Feedback\Index::class)->name('backend.feedback.index');

    Route::get('subscriber', \App\Livewire\Backend\Subscriber\Index::class)->name('backend.subscriber.index');
});

Route::group(['middleware' => ['auth', 'role:owner|admin']], function () {
    Route::get('category', \App\Livewire\Backend\Category\Index::class)->name('backend.category.index');

    //Admin users
    Route::get('user', \App\Livewire\Backend\User\Index::class)->name('backend.user.index');
    Route::get('user/password/edit', \App\Livewire\Backend\User\PasswordForm::class)->name('backend.user.password.edit');
    Route::get('user/create', \App\Livewire\Backend\User\Form::class)->name('backend.user.create');
    Route::get('user/{user}/edit', \App\Livewire\Backend\User\Form::class)->name('backend.user.edit');

    Route::get('keyword', \App\Livewire\Backend\Keyword\Index::class)->name('backend.keyword.index');
});

Route::group(['middleware' => ['auth', 'role:owner']], function () {
    //admin config
    Route::get('config', \App\Livewire\Backend\Config\Index::class)->name('backend.config.index');
});

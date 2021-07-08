<?php

namespace App\Providers;

use App\Http\View\Composer\CategoriesComposer;
use App\Http\View\Composer\GlobalConfigComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', CategoriesComposer::class, );
        View::composer('*', GlobalConfigComposer::class, );
    }
}

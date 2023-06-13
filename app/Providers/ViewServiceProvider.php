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
        //View::composer(['components/backend'], CategoriesComposer::class);
        View::composer(['components/backend', 'components/frontend'], GlobalConfigComposer::class);
    }
}

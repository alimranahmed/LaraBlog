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
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['livewire/backend/*'], CategoriesComposer::class);
        View::composer(['components/backend', 'components/frontend', 'emails/*'], GlobalConfigComposer::class);
    }
}

<?php

namespace App\Providers;

use App\Services\Google\GoogleDrive;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();

        GoogleDrive::loadStorageDriver();
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
    }
}

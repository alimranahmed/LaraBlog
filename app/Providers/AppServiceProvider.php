<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Config;
use App\Services\GeoIp\GeoIp;
use App\Services\GeoIp\IpStack;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        try {
            View::share('navCategories', Category::getNonEmptyOnly());
            View::share('globalConfigs', Config::allFormatted());
        } catch (\PDOException $e) {
            //TODO handle response
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GeoIp::class, IpStack::class);
    }
}

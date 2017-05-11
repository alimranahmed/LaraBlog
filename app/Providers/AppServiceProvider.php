<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Config;
use Illuminate\Support\Facades\Schema;
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
        try{
            View::share('navCategories', Category::getNonEmptyOnly());
            View::share('globalConfigs', Config::allFormatted());
        }catch(\PDOException $e){
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
        $this->app->alias('bugsnag.multi', \Illuminate\Contracts\Logging\Log::class);
        $this->app->alias('bugsnag.multi', \Psr\Log\LoggerInterface::class);
    }
}

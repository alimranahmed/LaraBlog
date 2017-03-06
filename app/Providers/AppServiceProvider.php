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
            View::share('navCategories', Category::where('is_active', 1)->get());
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
        //
    }
}

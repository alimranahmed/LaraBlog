<?php

namespace App\Providers;

use App\Services\Google\GoogleDrive;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('owner') ? true : null;
        });

        Paginator::useTailwind();

        GoogleDrive::loadStorageDriver();
    }

    /**
     * Register any application services.
     */
    public function register(): void {}
}

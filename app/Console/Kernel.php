<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //$schedule->command('get-ip-location')->hourly();

        $schedule->command('php artisan backup:run --only-db')->weekly();
        $schedule->command('backup:clean')->weekly();

        $schedule->command('sitemap:generate')->weekly();

        $schedule->command('telescope:prune')->daily();
    }

    /**
     * Register the Closure based commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}

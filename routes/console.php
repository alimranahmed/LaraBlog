<?php

use App\Console\Commands\GenerateSitemap;
use Illuminate\Support\Facades\Schedule;

Schedule::command('backup:run --only-db')->monthly();
Schedule::command(GenerateSitemap::class)->weekly();

if (class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
    Schedule::command('telescope:prune')->daily();
}

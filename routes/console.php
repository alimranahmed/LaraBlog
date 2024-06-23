<?php

use App\Console\Commands\GenerateSitemap;
use Illuminate\Support\Facades\Schedule;

Schedule::command('backup:run --only-db')->monthly();
Schedule::command(GenerateSitemap::class)->weekly();
Schedule::command('telescope:prune')->daily();

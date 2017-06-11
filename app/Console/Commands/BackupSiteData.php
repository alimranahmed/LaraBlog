<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupSiteData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:site-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup all data and send to system admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = env('DB_USERNAME');
        $host = env('DB_HOST');
        $pass = env('DB_PASSWORD');
        $dbName = env('DB_DATABASE');
        $path = "~/backup/$dbName.sql";
        exec("mysqldump --user=$user --password=$pass --host=$host $dbName > $path");
    }
}

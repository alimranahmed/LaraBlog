<?php

namespace App\Console\Commands;

use App\Mail\BackUpDatabase;
use App\Models\Config;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
        $path = "/home/backup/$dbName.sql";
        exec("mysqldump --user=$user --password=$pass --host=$host $dbName > $path");
        Mail::to(Config::get('admin_email'))->send(new BackUpDatabase($path));
    }
}

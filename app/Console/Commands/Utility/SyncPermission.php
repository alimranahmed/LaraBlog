<?php

namespace App\Console\Commands\Utility;

use Illuminate\Console\Command;
use Spatie\Permission\PermissionRegistrar;

class SyncPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utility:sync-permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->info('Syncing the roles and permission');
        (new \RolesAndPermissionsTableSeeder())->run();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->info('Synced roles an permission!');
    }
}

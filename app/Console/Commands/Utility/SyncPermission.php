<?php

namespace App\Console\Commands\Utility;

use Illuminate\Console\Command;
use Spatie\Permission\PermissionRegistrar;

class SyncPermission extends Command
{
    protected $signature = 'utility:sync-permission';

    protected $description = 'Sync permission based on acl.php config file';

    public function handle(): void
    {
        $this->info('Syncing the roles and permission');
        (new \RolesAndPermissionsTableSeeder())->run();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->info('Synced roles an permission!');
    }
}

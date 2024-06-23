<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $this->saveRole();
        $this->savePermissions();
        $this->generateRoleBasedPermissions();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function saveRole(): bool
    {
        Role::query()->whereNotIn('name', config('acl.roles'))->delete();

        $roles = [];
        $sl = 0;
        $getRoles = config('acl.roles');
        if (empty($getRoles) || ! is_array($getRoles)) {
            return true;
        }
        foreach ($getRoles as $key => $role) {
            if (Role::where('name', $role)->exists()) {
                continue;
            }
            $roles[$sl]['name'] = $role;
            $roles[$sl]['guard_name'] = 'web';
            $sl++;
        }

        return Role::query()->insert($roles);
    }

    public function savePermissions(): bool
    {
        Permission::whereNotIn('name', array_keys(config('acl.permissions')))->delete();

        $permissions = [];
        $getPermissions = config('acl.permissions');
        $sl = 0;
        if (empty($getPermissions) || ! is_array($getPermissions)) {
            return true;
        }
        foreach ($getPermissions as $permission => $roles) {
            if (Permission::where('name', $permission)->exists()) {
                continue;
            }
            $permissions[$sl]['name'] = $permission;
            $permissions[$sl]['guard_name'] = 'web';
            $sl++;
        }

        return Permission::query()->insert($permissions);
    }

    public function generateRoleBasedPermissions(): void
    {
        foreach (config('acl.roles') as $role) {
            $getRole = Role::where('name', $role)->first();
            $sl = 0;
            $formatRoles = [];
            foreach (config('acl.permissions') as $permission => $roles) {
                if (in_array($role, $roles)) {
                    $formatRoles[$sl++] = $permission;
                }
            }
            $getRole->syncPermissions($formatRoles);
        }
    }
}

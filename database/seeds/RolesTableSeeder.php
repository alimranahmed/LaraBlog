<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'owner',
            'display_name' => 'Owner',
            'description' => 'Owner of this blog'
        ]);

        Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'Admin of this blog'
        ]);

        Role::create([
            'name' => 'author',
            'display_name' => 'Author',
            'description' => 'Author of this blog'
        ]);

        Role::create([
            'name' => 'reader',
            'display_name' => 'Reader',
            'description' => 'Reader of this blog'
        ]);
    }
}

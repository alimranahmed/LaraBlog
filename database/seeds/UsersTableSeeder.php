<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(
            [
                'name' => 'Al- Imran Ahmed',
                'username' => 'owner',
                'password' => \Hash::make('owner'),
                'email' => 'owner@gmail.com',
                'last_ip' => '127.0.0.1',
            ]
        );
        $ownerRole = Role::where('name', 'owner')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $authorRole = Role::where('name', 'author')->first();
        $user->attachRoles([$ownerRole, $adminRole, $authorRole]);
    }
}

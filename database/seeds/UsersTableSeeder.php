<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env("APP_ENV") == 'local') {
            $owner = User::create(
                [
                    'name' => 'Al- Imran Ahmed',
                    'username' => 'owner',
                    'password' => \Hash::make('owner'),
                    'email' => 'owner@gmail.com',
                    'last_ip' => '127.0.0.1',
                ]
            );

            $admin = User::create(
                [
                    'name' => 'Admin',
                    'username' => 'admin',
                    'password' => \Hash::make('admin'),
                    'email' => 'admin@gmail.com',
                    'last_ip' => '127.0.0.1',
                ]
            );

            $author = User::create(
                [
                    'name' => 'Author',
                    'username' => 'author',
                    'password' => \Hash::make('author'),
                    'email' => 'author@gmail.com',
                    'last_ip' => '127.0.0.1',
                ]
            );
            $reader = User::create(
                [
                    'name' => 'Reader',
                    'username' => 'reader',
                    'password' => \Hash::make('reader'),
                    'email' => 'reader@gmail.com',
                    'last_ip' => '127.0.0.1',
                ]
            );
            $ownerRole = Role::where('name', 'owner')->first();
            $adminRole = Role::where('name', 'admin')->first();
            $authorRole = Role::where('name', 'author')->first();
            $readerRole = Role::where('name', 'reader')->first();
            $owner->assignRole([$ownerRole]);
            $admin->assignRole([$adminRole]);
            $author->assignRole([$authorRole]);
            $reader->assignRole([$readerRole]);
        } else {
            $owner = User::create(
                [
                    'name' => 'Al- Imran Ahmed',
                    'username' => 'al_imran_ahmed',
                    'password' => bcrypt('owner'),
                    'email' => 'al.imran.cse@gmail.com',
                    'last_ip' => '127.0.0.1',
                ]
            );
            $ownerRole = Role::where('name', 'owner')->first();

            $owner->assignRole($ownerRole);
        }
    }
}

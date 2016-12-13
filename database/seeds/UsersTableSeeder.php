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
        User::create(
            [
                'name' => 'Al- Imran Ahmed',
                'username' => 'admin',
                'password' => \Hash::make('admin'),
                'email' => 'admin@gmail.com',
                'role_id' => Role::where('name', 'OWNER')->first()->id,
                'last_ip' => '127.0.0.1',
            ]
        );
    }
}

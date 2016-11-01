<?php

use App\Models\Reader;
use Illuminate\Database\Seeder;

class ReadersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reader::create(
            [
                'name' => 'Al- Imran Ahmed',
                'email' => 'al.imran.cse@gmail.com',
                'last_ip' => '127.0.0.1',
                'is_verified' => 1,
                'notify' => 1
            ]
        );
        Reader::create(
            [
                'name' => 'Unverified User',
                'email' => 'unverified@gmail.com',
                'last_ip' => '127.0.0.1',
                'is_verified' => 0,
                'notify' => 0
            ]
        );
    }
}

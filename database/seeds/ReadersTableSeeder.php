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
                'is_verified' => 1,
                'notify' => 1
            ]
        );
        Reader::create(
            [
                'is_verified' => 0,
                'notify' => 0
            ]
        );
    }
}

<?php

use Illuminate\Database\Seeder;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Config::insert([
            ['name' => 'site_name', 'value' => 'Al- Imran Ahmed (-'],
            ['name' => 'site_title', 'value' => 'Al- Imran Ahmed (-'],
            ['name' => 'copyright_owner', 'value' => 'Al- Imran Ahmed (-'],
            ['name' => 'admin_email', 'value' => 'al.imran.cse@gmail.com'],
        ]);
    }
}

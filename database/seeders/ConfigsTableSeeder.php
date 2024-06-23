<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Config::query()->insert([
            ['name' => 'site_name', 'value' => 'Al- Imran Ahmed (-'],
            ['name' => 'site_title', 'value' => 'Al- Imran Ahmed (-'],
            ['name' => 'copyright_owner', 'value' => 'Al- Imran Ahmed (-'],
            ['name' => 'admin_email', 'value' => 'al.imran.cse@gmail.com'],
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class KeywordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env("APP_ENV") != 'production') {
            factory(\App\Models\Keyword::class, 5)->create();
        }
    }
}

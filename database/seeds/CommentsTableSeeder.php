<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(env("APP_ENV") == 'local') {
            factory(\App\Models\Comment::class, 10)->create();
        }
    }
}

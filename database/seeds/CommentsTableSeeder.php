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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        if(env("APP_ENV") == 'local') {
            factory(\App\Models\Comment::class, 30)->create();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

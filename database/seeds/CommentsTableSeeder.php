<?php

use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        if (env("APP_ENV") == 'local') {
            Comment::factory()->create([
                'article_id' => $faker->randomElement(\App\Models\Article::all()->pluck('id')->toArray()),
                'user_id' => $faker->randomElement(\App\Models\User::all()->pluck('id')->toArray()),
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

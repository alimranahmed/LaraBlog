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
        $faker = Faker\Factory::create();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        if (env("APP_ENV") == 'local') {
            factory(\App\Models\Comment::class, 30)->create([
                'article_id' => $faker->randomElement(\App\Models\Article::all()->pluck('id')),
                'user_id' => $faker->randomElement(\App\Models\User::all()->pluck('id')),
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

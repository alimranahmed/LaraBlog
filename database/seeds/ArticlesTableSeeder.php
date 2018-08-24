<?php

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = \Faker\Factory::create();
        if(env("APP_ENV") == 'local') {
            factory(\App\Models\Article::class, 10)->create([
                'category_id' => $faker->randomElement(\App\Models\Category::all()->pluck('id')),
                'user_id' => $faker->randomElement(\App\Models\User::all()->pluck('id')),
            ]);
            $articles = Article::all();
            foreach ($articles as $article) {
                $article->keywords()->attach($faker->numberBetween(1, 5));
            }
        }
    }
}

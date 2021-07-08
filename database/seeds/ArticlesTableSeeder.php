<?php

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->environment() != 'production') {
            $faker = \Faker\Factory::create();
            foreach (range(0, 10) as $i) {
                Article::factory()->create([
                    'category_id' => $faker->randomElement(\App\Models\Category::all()->pluck('id')->toArray()),
                    'user_id' => $faker->randomElement(\App\Models\User::all()->pluck('id')->toArray()),
                ]);
            }
            $articles = Article::all();
            foreach ($articles as $article) {
                $article->keywords()->attach($faker->numberBetween(1, 5));
            }
        }
    }
}

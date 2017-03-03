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
        factory(\App\Models\Article::class, 10)->create();
        $articles = Article::all();
        $faker = \Faker\Factory::create();
        foreach ($articles as $article){
            $article->keywords()->attach($faker->numberBetween(1, 5));
        }
    }
}

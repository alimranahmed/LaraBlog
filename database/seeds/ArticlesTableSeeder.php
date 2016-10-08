<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(\App\Models\Article::class, 10)->create();

        //Create pivot table entry
        for($i = 1; $i <= 10; $i++) {
            $faker = Faker\Factory::create();
            \DB::table('article_category')->insert([
                'article_id' => $i,
                'category_id' => $faker->numberBetween(1, 5)
            ]);
        }
    }
}

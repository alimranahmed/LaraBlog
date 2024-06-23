<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        if (app()->environment() != 'production') {
            foreach (Article::all() as $article) {
                Comment::factory()->count(3)->create([
                    'article_id' => $article->id,
                    'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
                ]);
                $article->update(['comment_count' => 3]);
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

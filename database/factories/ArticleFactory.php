<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'heading' => $heading = $this->faker->sentence,
            'content' => implode(' ', $this->faker->paragraphs(15)),
            'published_at' => now(),
            'is_published' => 1,
            'is_deleted' => 0,
            'user_id' => null,
            'language' => $language = $this->faker->randomElement(['ben', 'eng']),
            'slug' => Str::slug($heading, '-', $language),
            'category_id' => null,
        ];
    }

    public function published(): ArticleFactory
    {
        return $this->state([
            'is_published' => 1,
            'published_at' => now(),
        ]);
    }

    public function unpublished(): ArticleFactory
    {
        return $this->state([
            'is_published' => 0,
            'published_at' => new \DateTime('+3 days'),
        ]);
    }
}

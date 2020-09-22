<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'heading' => $this->faker->sentence,
            'content' => implode(' ', $this->faker->paragraphs(15)),
            'published_at' => now(),
            'is_published' => 1,
            'is_deleted' => 0,
            'user_id' => null,
            'language' => $this->faker->randomElement(['ben', 'eng']),
            'category_id' => null,
        ];
    }

    public function published()
    {
        return $this->state([
            'is_published' => 1,
            'published_at' => now(),
        ]);
    }

    public function unpublished()
    {
        return $this->state([
            'is_published' => 0,
            'published_at' => new \DateTime('+3 days'),
        ]);
    }
}

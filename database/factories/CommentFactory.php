<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph,
            'article_id' => null,
            'is_published' => 1,
            'published_at' => now(),
            'is_confirmed' => 1,
            'user_id' => null,
            'parent_comment_id' => null,
        ];
    }

    public function published(): CommentFactory
    {
        return $this->state([
            'is_published' => 1,
            'published_at' => now(),
        ]);
    }

    public function unpublished(): CommentFactory
    {
        return $this->state([
            'is_published' => 0,
            'published_at' => null,
        ]);
    }
}

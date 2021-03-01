<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Faker\Factory;

class ArticleTest extends WebTestCase
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Category
     */
    protected $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()
            ->create(['name' => 'Example User', 'email' => 'example@test.com']);

        $this->category = Category::factory()->create();
    }

    public function testIndex()
    {
        Article::factory()->published()->create([
            'heading' => 'Test Heading',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);


        Article::factory()->unpublished()->create([
            'heading' => 'Unpublished Heading',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);

        $this->get('article')
            ->assertOk()
            ->assertSee('Test Heading')
            ->assertSee("published 1 second ago")
            ->assertSee("by {$this->user->name}")
            ->assertSee("{$this->category->name}")
            ->assertDontSee('Unpublished Heading');
    }

    public function testShowPublished()
    {
        $article = Article::factory()->published()->create([
            'heading' => 'Test Heading',
            'content' => 'Test content',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ])->first();

        $this->get("article/{$article->id}/")
            ->assertOk();
    }

    public function testHideShowUnpublished()
    {
        $article = Article::factory()->unpublished()->create([
            'heading' => 'Unpublished Heading',
            'content' => 'Unpublished content',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);

        $this->get("article/{$article->id}/")
            ->assertRedirect()
            ->assertDontSee('Unpublished Heading')
            ->assertDontSee('Unpublished content');
    }
}

<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Category
     */
    protected $category;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class, 1)->create(['email' => 'example@test.com'])->first();

        $this->category = factory(Category::class, 1)->create()->first();
    }

    public function testPublishedScope()
    {
        factory(Article::class, 1)->state('published')->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
        ]);
        $article = Article::published()->first();
        $this->assertEquals(1, $article->is_published);
    }

    public function testNotDeletedScope()
    {
        factory(Article::class, 1)->create([
            'is_deleted' => 0,
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
        ]);

        $article = Article::notDeleted()->first();
        $this->assertEquals(0, $article->is_deleted);
    }

    public function testPublishedAtHumanAttribute()
    {
        $article = factory(Article::class, 1)->create([
            'published_at' => now(),
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
        ])->first();

        $this->assertEquals('1 second ago', $article->publishedAtHuman);
    }

    public function testCreatedAtHumanAttribute()
    {
        $article = factory(Article::class, 1)->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id
        ])->first();

        $this->assertEquals('1 second ago', $article->createdAtHuman);
    }

    public function testUpdatedAtHumanAttribute()
    {
        $article = factory(Article::class, 1)->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
        ])->first();

        $this->assertEquals('1 second ago', $article->updatedAtHuman);
    }

    public function testCategoryNameAttribute()
    {
        $category = factory(Category::class, 1)->create(['name' => 'Test Category'])->first();
        $article = factory(Article::class, 1)->create([
            'user_id' => $this->user->id,
            'category_id' => $category->id,
        ])->first();

        $this->assertEquals($category->name, $article->categoryName);
    }
}

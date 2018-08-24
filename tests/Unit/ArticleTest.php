<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

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
        $this->user = factory(User::class)->create(['email' => 'example@test.com']);

        $this->category = factory(Category::class)->create();
    }

    public function testPublishedScope()
    {
        factory(Article::class)->state('published')->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
        ]);
        $this->assertEquals(1, Article::published()->value('is_published'));
    }

    public function testNotDeletedScope()
    {
        factory(Article::class)->create([
            'is_deleted' => 0,
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
        ]);

        $article = Article::notDeleted()->first();
        $this->assertEquals(0, $article->is_deleted);
    }

    public function testPublishedAtHumanAttribute()
    {
        $article = factory(Article::class)->create([
            'published_at' => now(),
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
        ]);

        $this->assertEquals('1 second ago', $article->publishedAtHuman);
    }

    public function testCreatedAtHumanAttribute()
    {
        $article = factory(Article::class)->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id
        ]);

        $this->assertEquals('1 second ago', $article->createdAtHuman);
    }

    public function testUpdatedAtHumanAttribute()
    {
        $article = factory(Article::class)->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
        ]);

        $this->assertEquals('1 second ago', $article->updatedAtHuman);
    }

    public function testCategoryNameAttribute()
    {
        $category = factory(Category::class)->create(['name' => 'Test Category']);
        $article = factory(Article::class)->create([
            'user_id' => $this->user->id,
            'category_id' => $category->id,
        ]);

        $this->assertEquals($category->name, $article->categoryName);
    }
}

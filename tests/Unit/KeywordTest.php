<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Category;
use App\Models\Keyword;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class KeywordTest extends TestCase
{
    use DatabaseTransactions;

    protected $article;

    protected function setUp(): void
    {
        parent::setUp();

        $user =  User::factory()->create(['email' => 'example@test.com']);

        $category = Category::factory()->create();

        $this->article = Article::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
    }

    public function testCreatedAtHumanAttribute()
    {
        $keyword = Keyword::factory()->create([
            'name' => 'test_keyword',
        ]);

        $this->assertEquals('1 second ago', $keyword->createdAtHuman);
    }

    public function testGetArticleIds()
    {
        $keyword = Keyword::factory()->count(2)->create();

        $this->article->keywords()->attach($keyword->first()->id);


        $this->assertSame([$this->article->id], Keyword::getArticleIDs($keyword));
    }
}

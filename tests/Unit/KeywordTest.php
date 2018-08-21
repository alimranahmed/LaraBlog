<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Category;
use App\Models\Keyword;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KeywordTest extends TestCase
{
    use DatabaseTransactions;

    protected $article;

    protected function setUp()
    {
        parent::setUp();

        $user = factory(User::class, 1)->create(['email' => 'example@test.com'])->first();

        $category = factory(Category::class, 1)->create()->first();

        $this->article = factory(Article::class, 1)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ])->first();
    }

    public function testCreatedAtHumanAttribute()
    {
        $keyword = factory(Keyword::class, 1)->create([
            'name' => 'test_keyword',
        ])->first();

        $this->assertEquals('1 second ago', $keyword->createdAtHuman);
    }

    public function testGetArticleIds()
    {
        $keyword = factory(Keyword::class, 1)->create([
            'name' => 'test_keyword',
        ]);

        $this->article->keywords()->attach($keyword->first()->id);



        $this->assertSame([$this->article->id], Keyword::getArticleIDs($keyword));
    }
}

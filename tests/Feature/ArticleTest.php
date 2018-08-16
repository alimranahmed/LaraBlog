<?php

namespace Tests\Feature;

use App\Models\Article;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndex()
    {
        factory(Article::class, 1)->state('published')->create([
            'heading' => 'Test Heading',
        ]);


        factory(Article::class, 1)->state('unpublished')->create([
            'heading' => 'Unpublished Heading',
        ]);

        $this->get('article')
            ->assertOk()
            ->assertSee('Test Heading')
            ->assertDontSee('Unpublished Heading');
    }

    public function testShowPublished()
    {
        $article = factory(Article::class, 1)->state('published')->create([
            'heading' => 'Test Heading',
            'content' => 'Test content',
        ])->first();

        $this->get("article/{$article->id}/")
            ->assertOk()
            ->assertSee('Test Heading')
            ->assertSee('Test content');
    }

    public function testHideShowUnpublished()
    {
        $article = factory(Article::class, 1)->state('unpublished')->create([
            'heading' => 'Unpublished Heading',
            'content' => 'Unpublished content',
        ])->first();

        $this->get("article/{$article->id}/")
            ->assertRedirect()


            

            ->assertDontSee('Unpublished Heading')
            ->assertDontSee('Unpublished content');

    }
}

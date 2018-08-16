<?php

namespace Tests\Feature;

use App\Models\Article;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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

        $this->get('/article')
            ->assertSee('Test Heading')
            ->assertDontSee('Unpublished Heading');
    }


}

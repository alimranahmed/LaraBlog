<?php

namespace Tests\Feature\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Config;
use App\Models\User;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::updateOrCreate(['name' => 'site_title'], ['value' => 'Site title']);
    }

    public function testHomePage()
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();

        $article = Article::factory()->published()->create([
            'heading' => 'Test Heading',
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        Article::factory()->unpublished()->create([
            'heading' => 'Unpublished Heading',
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee($article->heading)
            ->assertSee($article->published_at->format('M d, Y'))
            ->assertSee("{$article->user->name}")
            ->assertSee("{$category->name}")
            ->assertDontSee('Unpublished Heading')
            ->assertSee(Config::get('site_title'));
    }
}

<?php

namespace Tests\Feature\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    public function testGetArticlesSuccessfully(): void
    {
        $category = Category::factory()->create();

        $articles = Article::factory()->count(3)->create([
            'category_id' => $category->id,
            'user_id' => User::factory()->create()->id,
        ]);

        $this->get("category/article/{$category->alias}")
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('frontend.articles.index')
            ->assertViewHas('articles')
            ->assertSee($articles->first()->heading);
    }
}

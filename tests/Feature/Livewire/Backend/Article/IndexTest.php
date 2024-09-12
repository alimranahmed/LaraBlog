<?php

namespace Tests\Feature\Livewire\Backend\Article;

use App\Livewire\Backend\Article\Index;
use App\Models\Article;
use App\Models\Category;
use App\Models\Keyword;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $author = Role::findOrCreate('author');
        $user->assignRole($author);
        Auth::loginUsingId($user->id);
    }

    public function testItRendersCorrectly()
    {
        Livewire::test(Index::class)->assertStatus(200);
    }

    public function testItFiltersArticlesBasedOnCategory()
    {
        $category = Category::factory()->create();
        Article::factory()->count(3)->create(['category_id' => $category->id]);
        Article::factory()->count(2)->create(); // Articles in different categories

        Livewire::test(Index::class)
            ->set('category', $category->id)
            ->assertSeeInOrder([$category->name], 'category')
            ->assertViewHas('articles', function ($articles) use ($category) {
                return $articles->every(fn ($article) => $article->category_id === $category->id);
            });
    }

    public function testItFiltersArticlesBasedOnKeyword()
    {
        $keyword = Keyword::factory()->create();
        $articleWithKeyword = Article::factory()->create();
        $articleWithKeyword->keywords()->attach($keyword);

        Article::factory()->count(2)->create(); // Articles without the keyword

        Livewire::test(Index::class)
            ->set('keyword', $keyword->name)
            ->assertSeeInOrder([$keyword->name], 'keywords')
            ->assertViewHas('articles', function ($articles) use ($keyword) {
                return $articles->every(fn ($article) => $article->keywords->contains($keyword));
            });
    }

    public function testItFiltersArticlesBasedOnSearchQuery()
    {
        $query = 'Unique Title';
        Article::factory()->create(['heading' => $query]);
        Article::factory()->count(2)->create(['heading' => 'Other Title']);

        Livewire::test(Index::class)
            ->set('query', $query)
            ->assertViewHas('articles', function ($articles) use ($query) {
                return $articles->every(fn ($article) => stripos($article->heading, $query) !== false);
            });
    }
}

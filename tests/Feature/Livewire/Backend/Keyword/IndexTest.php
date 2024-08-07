<?php

namespace Tests\Feature\Livewire\Backend\Keyword;

use App\Livewire\Backend\Keyword\Index;
use App\Models\Article;
use App\Models\Keyword;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public function testRender()
    {
        Livewire::test(Index::class)
            ->assertOk()
            ->assertViewIs('livewire.backend.keyword.index')
            ->assertViewHas('keywords');
    }

    public function testDelete()
    {
        $keyword = Keyword::factory()->create();
        $article = Article::factory()->create();
        $article->keywords()->attach($keyword);

        Livewire::test(Index::class)
            ->call('delete', $keyword)
            ->assertOk()
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('keywords', [
            'id' => $keyword->id,
        ]);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
        ]);
    }
}

<?php

namespace Tests\Feature\Livewire\Backend\Comment;

use App\Livewire\Backend\Comment\Index;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Auth::login($this->user);
    }

    public function testRender(): void
    {
        $article = Article::factory()->create();

        Comment::factory()->create([
            'article_id' => $article->id,
            'user_id' => $this->user->id,
        ]);

        Livewire::test(Index::class)
            ->assertStatus(Response::HTTP_OK);
    }

    public function testPlaceholder()
    {
        Livewire::test(Index::class)
            ->call('placeholder')
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('livewire.backend.comment.index')
            ->assertViewHas('comments');

    }
}

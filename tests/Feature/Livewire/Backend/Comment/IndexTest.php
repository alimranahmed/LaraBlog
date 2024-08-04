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
    public function testRender(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $article = Article::factory()->create();

        Comment::factory()->create([
            'article_id' => $article->id,
            'user_id' => $user->id,
        ]);

        Livewire::test(Index::class)
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('livewire.backend.comment.index')
            ->assertViewHas('comments');
    }
}

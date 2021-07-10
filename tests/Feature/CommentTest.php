<?php

namespace Tests\Feature;

use App\Http\Livewire\Article\Comments;
use App\Mail\CommentConfirmation;
use App\Mail\NotifyAdmin;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Config;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

class CommentTest extends WebTestCase
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var Article
     */
    protected $article;

    public function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'reader']);

        $this->user =  User::factory()
            ->create(['name' => 'Example User', 'email' => 'example@test.com']);

        $this->category = Category::factory()->create();

        $this->article = Article::factory()->published()->create([
            'heading' => 'Test Heading',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function testStore()
    {
        Mail::fake();

        Config::create(['name' => 'admin_email', 'value' => 'imran@example.com']);

        Livewire::test(Comments::class, ['article' => $this->article])
            ->set('comment.content', $content = 'test comment')
            ->set('comment.email', $email = 'test@example.com')
            ->set('comment.name', $name = 'Al Imran Ahmed')
            ->set('comment.notify', 1)
            ->call('add');

        Mail::assertQueued(CommentConfirmation::class);
        Mail::assertQueued(NotifyAdmin::class);

        $comment = Comment::where('article_id', $this->article->id)->where('content', $content)->first();
        $this->assertNotNull($comment);
        $this->assertEquals(0, $comment->is_published);
        $this->assertEquals(0, $comment->is_confirmed);

        $user = User::where('email', $email)->first();
        $this->assertNotNull($user);
        $this->assertEquals($name, $user->name);

        $this->assertEquals(1, $user->reader->notify);
        $this->assertEquals(0, $user->reader->is_verified);
    }

    public function testStoreValidation()
    {
        Livewire::test(Comments::class, ['article' => $this->article])
            ->call('add')
            ->assertHasErrors('comment.name')
            ->assertHasErrors('comment.email')
            ->assertHasErrors('comment.content');
    }

    public function testConfirmComment()
    {
        $comment = Comment::factory()
            ->create([
                'user_id' => $this->user->id,
                'article_id' => $this->article->id,
                'is_published' => 0,
                'is_confirmed' => 0,
                'token' => 'test-token',
            ]);

        $this->get("comment/{$comment->id}/confirm/?token={$comment->token}")
            ->assertRedirect(route('get-article', [$comment->article->id]));


        $comment = Comment::find($comment->id);

        $this->assertEquals(1, $comment->is_published);
        $this->assertEquals(1, $comment->is_confirmed);

        $comment->update([
            'is_published' => 0,
            'is_confirmed' => 0,
            'token' => 'test-token'
        ]);

        $this->get("comment/{$comment->id}/confirm/?token=invalid-token")
            ->assertRedirect(route('home'));

        $this->assertEquals(0, $comment->is_published);
        $this->assertEquals(0, $comment->is_confirmed);
    }
}

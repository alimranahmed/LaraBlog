<?php

namespace Tests\Feature;

use App\Mail\CommentConfirmation;
use App\Mail\NotifyAdmin;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

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

        $content = 'test comment';
        $email = 'test@example.com';
        $name = 'Imran Ahmed';
        $data = [
            'name' => $name,
            'email' => $email,
            'content' => $content,
            'notify' => 1,
        ];

        $headers = ['Accept' => 'application/json'];

        $this->post("comment/{$this->article->id}", $data, $headers)->assertOk();

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
        $data = [];
        $headers = ['Accept' => 'application/json'];

        $response = $this->post("comment/{$this->article->id}", $data, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name', 'email', 'content']);
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

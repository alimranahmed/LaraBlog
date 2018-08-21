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
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class, 1)
            ->create(['name' => 'Example User', 'email' => 'example@test.com'])
            ->first();

        $this->category = factory(Category::class, 1)->create()->first();

        $this->article = factory(Article::class, 1)->state('published')->create([
            'heading' => 'Test Heading',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ])->first();
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
}

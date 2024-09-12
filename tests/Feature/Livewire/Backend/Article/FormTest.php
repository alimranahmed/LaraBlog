<?php

namespace Tests\Feature\Livewire\Backend\Article;

use App\Livewire\Backend\Article\Form;
use App\Mail\NotifySubscriberForNewArticle;
use App\Models\Article;
use App\Models\Category;
use App\Models\Reader;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class FormTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $role = Role::findOrCreate('owner');
        $this->user->assignRole($role);
        Auth::login($this->user);
    }

    public function testRender(): void
    {
        Livewire::test(Form::class)
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('livewire.backend.article.form')
            ->assertViewHas('categories');
    }

    public function testInitializesCorrectlyWithoutArticle()
    {
        Livewire::test(Form::class)
            ->assertSet('method', 'post')
            ->assertSet('articleData', []);
    }

    public function testInitializesCorrectlyWithArticle()
    {
        $article = Article::factory()->create();
        Livewire::test(Form::class, ['article' => $article])
            ->assertSet('method', 'put')
            ->assertSet('articleData.heading', $article->heading)
            ->assertSet('articleData.slug', $article->slug)
            ->assertSet('articleData.category_id', $article->category_id);
    }

    public function testGeneratesSlugWhenHeadingChanges()
    {
        Livewire::test(Form::class)
            ->set('articleData.heading', 'New Article')
            ->set('articleData.language', 'en')
            ->assertSet('articleData.slug', Str::slug('New Article'));
    }

    public function testValidatesArticleDataCorrectly()
    {
        Livewire::test(Form::class)
            ->set('articleData.heading', '')
            ->set('articleData.slug', '')
            ->set('articleData.category_id', null)
            ->set('articleData.content', '')
            ->set('articleData.language', '')
            ->call('submit')
            ->assertHasErrors([
                'articleData.heading' => 'required',
                'articleData.slug' => 'required',
                'articleData.category_id' => 'required',
                'articleData.content' => 'required',
                'articleData.language' => 'required',
            ]);
    }

    public function testStoresANewArticleCorrectly()
    {
        Mail::fake();
        Auth::loginUsingId(User::factory()->create()->id);

        $user = User::factory()->create();
        Reader::query()->create([
            'user_id' => $user->id,
            'notify' => true,
            'is_verified' => true,
        ]);

        $category = Category::factory()->create();
        $data = [
            'heading' => 'Test Article',
            'slug' => 'test-article',
            'category_id' => $category->id,
            'content' => 'This is a test article.',
            'language' => 'en',
            'is_comment_enabled' => true,
            'meta' => [
                'description' => 'Test description',
                'image_url' => 'http://example.com/image.jpg',
            ],
            'keywords' => 'test article',
        ];

        Livewire::test(Form::class, ['article' => null])
            ->set('articleData', $data)
            ->call('submit')
            ->assertSessionHas('success', 'Article published successfully!');

        $this->assertDatabaseHas('articles', ['heading' => 'Test Article']);
        $this->assertDatabaseHas('keywords', ['name' => 'test']);
        $this->assertDatabaseHas('keywords', ['name' => 'article']);
        Mail::assertQueued(NotifySubscriberForNewArticle::class);
    }

    public function testUpdatesAnExistingArticleCorrectly()
    {
        Mail::fake();

        $article = Article::factory()->create();
        $data = [
            'heading' => 'Updated Article',
            'slug' => 'updated-article',
            'category_id' => $article->category_id,
            'content' => 'This is an updated article.',
            'language' => 'en',
            'is_comment_enabled' => true,
            'meta' => [
                'description' => 'Updated description',
                'image_url' => 'http://example.com/updated-image.jpg',
            ],
            'keywords' => 'updated article',
        ];

        Livewire::test(Form::class, ['article' => $article])
            ->set('articleData', $data)
            ->call('submit')
            ->assertSessionHas('successMsg', 'Article updated successfully!');

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'heading' => 'Updated Article',
        ]);
        $this->assertDatabaseHas('keywords', ['name' => 'updated']);
        $this->assertDatabaseHas('keywords', ['name' => 'article']);
    }
}

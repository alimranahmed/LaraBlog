<?php

namespace Tests\Feature\Controllers\Backend;

use App\Models\Article;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $role = Role::query()->createOrFirst(['name' => 'owner']);
        $this->user->assignRole($role);
    }

    public function testIndex()
    {
        $this->actingAs($this->user)->get('/admin/article')
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('backend.articles.index');
    }

    public function testCreate()
    {
        $this->actingAs($this->user)->get('/admin/article/create')
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('backend.articles.create');
    }

    public function testEdit()
    {
        $article = Article::factory()->create();

        $this->actingAs($this->user)->get("/admin/article/$article->id/edit")
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('backend.articles.edit');
    }

    public function testEditForUnauthorizedUser()
    {
        $reader = User::factory()->create();
        $role = Role::query()->createOrFirst(['name' => 'author']);
        $reader->assignRole($role);

        $article = Article::factory()->create();

        $this->actingAs($reader)->get("/admin/article/$article->id/edit")
            ->assertRedirectToRoute('home')
            ->assertSessionHas('errorMsg');
    }
}

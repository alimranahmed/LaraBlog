<?php

namespace Tests\Feature\Controllers\Backend;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    protected User $user;

    protected Category $category;

    protected Article $article;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $role = Role::findOrCreate('owner');
        $this->user->assignRole($role);
    }

    public function testIndex()
    {
        $this->actingAs($this->user)->get('/admin/category')
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('backend.categories.index');
    }
}

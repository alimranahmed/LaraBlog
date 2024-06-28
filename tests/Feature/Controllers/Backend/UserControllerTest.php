<?php

namespace Tests\Feature\Controllers\Backend;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $role = Role::findOrCreate('owner');
        $this->user->assignRole($role);
    }

    public function testIndex()
    {
        $response = $this->actingAs($this->user)->get('/admin/user');
        $response->assertStatus(Response::HTTP_OK)
            ->assertViewIs('backend.users.index');
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->user)->get('/admin/user/create');
        $response->assertStatus(Response::HTTP_OK)
            ->assertViewIs('backend.users.create')
            ->assertViewHas('roles');
    }

    public function testEdit()
    {
        $editingUser = User::factory()->create();

        $response = $this->actingAs($this->user)
            ->get("/admin/user/{$editingUser->id}/edit");

        $response->assertStatus(Response::HTTP_OK)
            ->assertViewIs('backend.users.edit')
            ->assertViewHas('user', $editingUser);
    }

    public function testEditPassword()
    {
        $response = $this->actingAs($this->user)
            ->get('/admin/user/password/edit');

        $response->assertStatus(Response::HTTP_OK)
            ->assertViewIs('backend.users.edit_password');
    }

    public function testProfile()
    {
        $response = $this->actingAs($this->user)->get('/admin/profile');
        $response->assertStatus(Response::HTTP_OK)
            ->assertViewIs('backend.users.show')
            ->assertViewHas('user', $this->user);

    }
}

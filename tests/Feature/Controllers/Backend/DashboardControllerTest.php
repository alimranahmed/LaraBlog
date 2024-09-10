<?php

namespace Tests\Feature\Controllers\Backend;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
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
        $this->actingAs($this->user)->get('/admin/dashboard')
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('backend.dashboard');
    }
}

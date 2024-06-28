<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function testShowLoginForm(): void
    {
        $this->get('admin/login')
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('backend.auth')
            ->assertSee('Login')
            ->assertSee('Go to Home')
            ->assertSee('Welcome...');
    }

    public function testDontShowLoginFormIfAlreadyLoggedIn()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->get('admin/login')
            ->assertRedirectToRoute('admin-dashboard');
    }

    public function testSuccessfulLogin()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make($password = 'password'),
        ]);

        $this->post('admin/login', [
            'email' => $user->email,
            'password' => $password,
        ])->assertRedirectToRoute('admin-dashboard');
    }

    public function testFailedLogin()
    {
        $user = User::factory()->create();

        $this->post('admin/login', [
            'email' => $user->email,
            'password' => Str::random().time(),
        ])->assertStatus(302)
            ->assertSessionHas('auth_error');
    }

    public function testLoginValidationFails()
    {
        $this->post('admin/login', [
            'email' => '',
            'password' => '',
            'remember_me' => '',
        ])->assertStatus(302)
            ->assertSessionHasErrors(['email', 'password']);
    }

    public function testLogout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get('admin/logout')
            ->assertRedirectToRoute('login-form');

        $this->assertFalse(Auth::check());
    }
}

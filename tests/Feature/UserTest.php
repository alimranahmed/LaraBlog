<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testUserCanLogin()
    {
        $user = User::factory()->create([
            'email' => 'random@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => '123456',
        ])->assertRedirect(route('admin-dashboard'));
    }
}

<?php

namespace Tests\Feature;

use App\Mail\SubscribeConfirmation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserCanLogin()
    {
        $user =  User::factory()->create([
            'email' => 'random@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => '123456',
        ])->assertRedirect(route('admin-dashboard'));
    }

    public function testSubscribe()
    {
        Mail::fake();

        $data = [
            'name' => 'Al Imran Ahmed',
            'email' => 'imran@gmail.com',
        ];
        $this->post('subscribe', $data)
            ->assertRedirect();

        $user = User::whereEmail($data['email'])->first();

        $this->assertNotNull($user);
        $this->assertNotNull($user->reader);
        $this->assertEquals(0, $user->reader->notify);
        $this->assertEquals(0, $user->reader->is_verified);

        Mail::assertQueued(SubscribeConfirmation::class);
    }

    public function testUnsubscribe()
    {
        $user =  User::factory()->create(['token' => 'test-token']);
        $user->reader()->create(['notify' => 0, 'is_verified' => 0]);

        $this->get("confirm-subscription/{$user->id}/?token=test-token")
            ->assertRedirect();

        $this->assertEquals(1, $user->reader->notify);
        $this->assertEquals(1, $user->reader->is_verified);
    }

    public function testConfirmSubscription()
    {
        $user =  User::factory()->create(['token' => 'test-token']);
        $user->reader()->create(['notify' => 1, 'is_verified' => 0]);

        $this->get("un-subscribe/{$user->id}/?token=test-token")
            ->assertRedirect();

        $this->assertEquals(0, $user->reader->notify);
        $this->assertEquals(1, $user->reader->is_verified);
    }
}

<?php

namespace Tests\Feature;

use App\Http\Livewire\Subscribe;
use App\Mail\SubscribeConfirmation;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Livewire;
use PharIo\Manifest\Email;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

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

    public function testSubscribe()
    {
        Mail::fake();

        $data = [
            'name' => 'Al Imran Ahmed',
            'email' => 'imran@gmail.com',
        ];

        Livewire::test(Subscribe::class)
            ->set('email', $email = 'imran@gmail.com')
            ->call('subscribe');

        $this->assertDatabaseHas('subscribers', [
            'email' => $email,
            'unsubscribed_at' => null,
        ]);

        Mail::assertQueued(SubscribeConfirmation::class);
    }

    public function testUnsubscribe()
    {
        $subscriber = Subscriber::factory()->create(['unsubscribed_at' => null,]);

        $this->get("unsubscribe?token={$subscriber->token}")->assertRedirect();

        $this->assertNotNull($subscriber->fresh()->unsubscribed_at);
    }

    public function testConfirmSubscription()
    {
        $subscriber = Subscriber::factory()->create();

        $this->get("subscription/confirm?token={$subscriber->token}")->assertRedirect();

        $this->assertNull($subscriber->fresh()->unsubscribed_at);
    }
}

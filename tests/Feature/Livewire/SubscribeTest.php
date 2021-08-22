<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Frontend\Subscribe;
use App\Mail\SubscribeConfirmation;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    public function testSubscribe()
    {
        Mail::fake();

        Livewire::test(Subscribe::class)
            ->set('email', $email = 'imran@gmail.com')
            ->call('subscribe');

        $this->assertDatabaseHas('subscribers', [
            'email' => $email,
            'unsubscribed_at' => null,
        ]);

        Mail::assertQueued(SubscribeConfirmation::class);
    }
}

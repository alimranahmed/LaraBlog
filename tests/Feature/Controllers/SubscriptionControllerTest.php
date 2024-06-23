<?php

namespace Tests\Feature\Controllers;

use App\Models\Subscriber;
use Tests\TestCase;

class SubscriptionControllerTest extends TestCase
{
    public function testUnsubscribe()
    {
        $subscriber = Subscriber::factory()->create(['unsubscribed_at' => null]);

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

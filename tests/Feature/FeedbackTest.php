<?php

namespace Tests\Feature;

use App\Mail\NotifyAdmin;
use App\Models\Feedback;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    use DatabaseTransactions;

    public function testStore()
    {
        //$this->disableExceptionHandling();
        Mail::fake();

        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'content' => 'Test feedback',
        ];

        $this->post('feedback', $data)
            ->assertRedirect();

        $feedback = Feedback::where('email', $data['email'])->first();

        $this->assertNotNull($feedback);

        $this->assertEquals($data['name'], $feedback->name);
        $this->assertEquals($data['content'], $feedback->content);

        Mail::assertQueued(NotifyAdmin::class);
    }
}

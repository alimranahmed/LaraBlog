<?php

namespace Tests\Feature;

use App\Http\Livewire\ContactForm;
use App\Mail\NotifyAdmin;
use App\Models\Config;
use App\Models\Feedback;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    use DatabaseTransactions;

    public function testStore()
    {
        Mail::fake();
        Config::create(['name' => 'admin_email', 'value' => 'imran@example.com']);

        Livewire::test(ContactForm::class)
            ->set('name', $name = 'Test User')
            ->set('email', $email = 'test@example.com')
            ->set('content', $content = 'Test feedback')
            ->call('submit');

        $this->assertDatabaseHas('feedbacks', compact('name', 'email', 'content'));

        Mail::assertQueued(NotifyAdmin::class);
    }
}

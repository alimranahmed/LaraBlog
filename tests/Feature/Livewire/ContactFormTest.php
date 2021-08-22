<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Frontend\ContactForm;
use App\Mail\NotifyAdmin;
use App\Models\Config;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    public function testSubmit()
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

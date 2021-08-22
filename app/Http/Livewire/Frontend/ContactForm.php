<?php

namespace App\Http\Livewire\Frontend;

use App\Mail\NotifyAdmin;
use App\Models\Config;
use App\Models\Feedback;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use function route;
use function view;

class ContactForm extends Component
{
    public $isSubmitted = false;

    public $name;
    public $email;
    public $content;

    public $rules = [
        'name' => ["required", 'max:255', "not_regex:/(http|ftp|mailto|www\.|\.com)/"],
        'email' => "email|required|max:255",
        'content' => ["required", 'max:1500', "not_regex:/(http|ftp|mailto|www\.|\.com)/"],
    ];

    public function render()
    {
        return view('livewire.frontend.contact-form');
    }

    public function submit()
    {
        $this->validate();

        $feedback = Feedback::create([
            'email' => $this->email,
            'name' => $this->name,
            'content' => $this->content,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
        ]);

        Mail::to(Config::get('admin_email'))->queue(new NotifyAdmin($feedback, route('login-form')));

        $this->isSubmitted = true;
    }
}

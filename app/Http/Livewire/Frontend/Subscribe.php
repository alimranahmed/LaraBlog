<?php

namespace App\Http\Livewire\Frontend;

use App\Mail\SubscribeConfirmation;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;
use function view;

class Subscribe extends Component
{
    public $email;

    public $isSubscribed = false;

    public $rules = [
        'email' => 'required|email|max:255',
    ];

    public function render()
    {
        return view('livewire.frontend.subscribe');
    }

    public function subscribe()
    {
        $this->validate();

        $subscriber = Subscriber::firstOrCreate(
            ['email' => $this->email],
            ['token' => $this->generateUniqueToken()]
        );

        Mail::to($this->email)->queue(new SubscribeConfirmation($subscriber));

        $this->isSubscribed = true;
    }

    private function generateUniqueToken(): string
    {
        do {
            $token = Str::random();
        } while (Subscriber::where('token', $token)->exists());

        return $token;
    }
}

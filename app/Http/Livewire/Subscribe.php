<?php

namespace App\Http\Livewire;

use App\Models\Subscriber;
use Illuminate\Support\Str;
use Livewire\Component;

class Subscribe extends Component
{
    public $email;

    public $isSubscribed = false;

    public $rules = [
        'email' => 'required|email|max:255',
    ];

    public function render()
    {
        return view('livewire.subscribe');
    }

    public function subscribe()
    {
        $this->validate();

        Subscriber::firstOrCreate(
            ['email' => $this->email],
            ['unsubscribable_token' => $this->generateUnsubscribableToken()]
        );

        $this->isSubscribed = true;
    }

    private function generateUnsubscribableToken(): string
    {
        do {
            $token = Str::random();
        } while (Subscriber::where('unsubscribable_token', $token)->exists());

        return $token;
    }
}

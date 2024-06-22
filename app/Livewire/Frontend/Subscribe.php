<?php

namespace App\Livewire\Frontend;

use App\Mail\SubscribeConfirmation;
use App\Models\Subscriber;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

use function view;

class Subscribe extends Component
{
    public string $email = '';

    public bool $isSubscribed = false;

    public array $rules = [
        'email' => 'required|email|max:255',
    ];

    public function subscribe(): void
    {
        $this->validate();

        /** @var Subscriber $subscriber */
        $subscriber = Subscriber::query()
            ->firstOrCreate(
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
        } while (Subscriber::query()->where('token', $token)->exists());

        return $token;
    }

    public function render(): View
    {
        return view('livewire.frontend.subscribe');
    }
}

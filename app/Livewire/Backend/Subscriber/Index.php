<?php

namespace App\Livewire\Backend\Subscriber;

use App\Models\Subscriber;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Index extends Component
{
    public function placeholder(): View
    {
        return view('livewire.placeholders.cards');
    }

    public function render(): View
    {
        $subscribers = Subscriber::query()->latest()->paginate();

        return view('livewire.backend.subscriber.index', compact('subscribers'));
    }
}

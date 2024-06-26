<?php

namespace App\Livewire\Backend\Subscriber;

use App\Models\Subscriber;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        $subscribers = Subscriber::query()->latest()->paginate();

        return view('livewire.backend.subscriber.index', compact('subscribers'));
    }
}

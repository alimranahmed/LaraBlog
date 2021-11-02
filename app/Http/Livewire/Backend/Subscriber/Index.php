<?php

namespace App\Http\Livewire\Backend\Subscriber;

use App\Models\Subscriber;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $subscribers = Subscriber::latest()->paginate();
        return view('livewire.backend.subscriber.index', compact('subscribers'));
    }
}

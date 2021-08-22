<?php

namespace App\Http\Livewire\Backend\Feedback;

use App\Models\Feedback;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $feedbacks = Feedback::where('is_closed', 0)->latest()->paginate(15);
        return view('livewire.backend.feedback.index', compact('feedbacks'));
    }

    public function toggleResolved(Feedback $feedback)
    {
        $feedback->update(['is_resolved' => !$feedback->is_resolved]);
    }

    public function close(Feedback $feedback)
    {
        $feedback->update(['is_closed' => 1]);
    }
}

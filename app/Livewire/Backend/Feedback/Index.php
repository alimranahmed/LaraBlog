<?php

namespace App\Livewire\Backend\Feedback;

use App\Models\Feedback;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy]
class Index extends Component
{
    use WithPagination;

    public function toggleResolved(Feedback $feedback): void
    {
        $feedback->update(['is_resolved' => ! $feedback->is_resolved]);
    }

    public function close(Feedback $feedback): void
    {
        $feedback->update(['is_closed' => 1]);
    }

    public function placeholder(): View
    {
        return view('livewire.placeholders.cards');
    }

    public function render(): View
    {
        $feedbacks = Feedback::query()
            ->where('is_closed', 0)
            ->latest()
            ->paginate(15);

        return view('livewire.backend.feedback.index', compact('feedbacks'));
    }
}

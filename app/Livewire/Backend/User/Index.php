<?php

namespace App\Livewire\Backend\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\Response;

#[Lazy]
class Index extends Component
{
    use WithPagination;

    public function toggleActive(User $user): void
    {
        $user->update(['is_active' => ! $user->is_active]);
    }

    public function delete(User $user): void
    {
        if (auth()->id() == $user->id) {
            abort(Response::HTTP_UNAUTHORIZED);
        }
        $user->delete();
    }

    public function placeholder(): View
    {
        return view('livewire.placeholders.list');
    }

    public function render(): View
    {
        $users = User::with('roles')->latest()->paginate(config('blog.item_per_page'));

        return view('livewire.backend.user.index', compact('users'));
    }
}

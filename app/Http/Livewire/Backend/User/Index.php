<?php

namespace App\Http\Livewire\Backend\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $users = User::with('roles')->latest()->paginate(config('blog.item_per_page'));

        return view('livewire.backend.user.index', compact('users'));
    }

    public function toggleActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
    }

    public function delete(User $user)
    {
        if (auth()->id() == $user->id) {
            throw new \HttpException('Unauthorized');
        }
        $user->delete();
    }
}

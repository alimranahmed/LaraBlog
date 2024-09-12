<?php

namespace App\Livewire\Backend\User;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Profile extends Component
{
    public function render(): View
    {
        $user = Auth::user();

        return view('livewire.backend.user.profile', compact('user'));
    }
}

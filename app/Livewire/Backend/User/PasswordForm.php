<?php

namespace App\Livewire\Backend\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class PasswordForm extends Component
{
    public string $old_password;

    public string $new_password;

    public string $confirm_new_password;

    public array $rules = [
        'old_password' => 'required',
        'new_password' => 'required',
        'confirm_new_password' => 'required|same:new_password',
    ];

    public function render(): View
    {
        return view('livewire.backend.user.password-form');
    }

    /**
     * @throws ValidationException
     */
    public function update(): void
    {
        $this->validate();

        if (! Hash::check($this->old_password, Auth::user()->password)) {
            throw ValidationException::withMessages(['old_password' => 'Incorrect password']);
        }

        User::query()
            ->where('id', Auth::user()->id)
            ->update(['password' => Hash::make($this->new_password)]);

        $this->reset('old_password', 'new_password', 'confirm_new_password');

        $this->dispatch('success', ['message' => 'Password updated successfully!']);
    }
}

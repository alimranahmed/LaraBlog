<?php

namespace App\Http\Livewire\Backend\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class PasswordForm extends Component
{
    public $old_password;
    public $new_password;
    public $confirm_new_password;

    public $rules = [
        'old_password' => 'required',
        'new_password' => 'required',
        'confirm_new_password' => 'required|same:new_password',
    ];

    public function render()
    {
        return view('livewire.backend.user.password-form');
    }

    public function update()
    {
        $this->validate();

        if (!Hash::check($this->old_password, Auth::user()->password)) {
            throw ValidationException::withMessages(['old_password' => 'Incorrect password']);
        }

        User::where('id', Auth::user()->id)
            ->update(['password' => Hash::make($this->new_password)]);

        $this->reset('old_password', 'new_password', 'confirm_new_password');

        $this->emit('success', ['message' => 'Password updated successfully!']);
    }
}

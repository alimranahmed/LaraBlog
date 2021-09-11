<?php

namespace App\Http\Livewire\Backend\User;

use App\Models\User;
use Illuminate\Support\Arr;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Form extends Component
{
    public $user;

    public $rules = [
        'user.name' => 'required',
        'user.username' => '',
        'user.email' => 'required|email',
        'user.role' => 'required'
    ];

    public $editingUser;

    public function mount(?User $user)
    {
        $this->editingUser = $user;
        $this->user = $user;
        $this->user->role = $this->user->roles()->value('id');
    }

    public function render()
    {
        $roles = Role::all();
        return view('livewire.backend.user.form', compact('roles'));
    }

    public function submit()
    {
        $data = $this->validate();

        $personalData = Arr::get($data, 'user');

        if ($this->editingUser->id) {
            $this->editingUser->update($personalData);
            $this->editingUser->roles()->detach();
            $this->editingUser->assignRole($personalData['role']);
        } else {
            $user = User::create($personalData);
            $user->assignRole($personalData['role']);
        }

        return redirect()->to(route('backend.user.index'));
    }
}

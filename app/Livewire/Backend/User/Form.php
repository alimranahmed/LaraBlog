<?php

namespace App\Livewire\Backend\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Form extends Component
{
    public User $user;

    public array $rules = [
        'userData.name' => 'required',
        'userData.username' => '',
        'userData.email' => 'required|email',
        'userData.role' => 'required',
    ];

    public array $userData = [];

    public function mount(?User $user): void
    {
        $this->user = $user;
        $this->userData = $user->toArray();
        $this->userData['role'] = $user->roles()->value('id');
    }

    public function render(): View
    {
        $roles = Role::all();

        return view('livewire.backend.user.form', compact('roles'));
    }

    public function submit(): void
    {
        $data = $this->validate();

        $personalData = Arr::get($data, 'userData');

        if ($this->user->id) {
            $this->user->update($personalData);
            $this->user->roles()->detach();
            $this->user->assignRole($personalData['role']);
        } else {
            /** @var User $user */
            $user = User::query()->create($personalData);
            $user->assignRole($personalData['role']);
        }

        $this->redirect(route('backend.user.index'), true);
    }
}

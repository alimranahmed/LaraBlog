<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('backend.users.index');
    }

    public function create(): View
    {
        $roles = Role::query()->where('name', '!=', 'owner')->get();

        return view('backend.users.create', compact('roles'));
    }

    public function edit(User $user): View
    {
        return view('backend.users.edit', compact('user'));
    }

    public function editPassword(): View
    {
        return view('backend.users.edit_password');
    }

    public function profile(): View
    {
        $user = Auth::user();

        return view('backend.users.show', compact('user'));
    }
}

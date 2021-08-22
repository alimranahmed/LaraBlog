<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('backend.users.index');
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'owner')->get();
        return view('backend.users.create', compact('roles'));
    }

    public function edit(User $user)
    {
        return view('backend.users.edit', compact('user'));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $newPassword = $request->get('new_password');

        if (!Hash::check($request->get('old_password'), Auth::user()->password)) {
            return back()->with('errorMsg', 'Unauthorized request');
        }
        try {
            User::where('id', Auth::user()->id)->update(['password' => Hash::make($newPassword)]);
        } catch (\PDOException $e) {
            Log::error($this->getLogMsg($e));
            return back()->with('errorMsg', $this->getMessage($e));
        }

        return back()->with('successMsg', 'Password changed');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('backend.users.show', compact('user'));
    }
}

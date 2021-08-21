<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
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
        return view('backend.user_create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $newUser = $request->only('title', 'name', 'username', 'email', 'website');
        $newUser['password'] = Hash::make($request->get('password'));
        try {
            $newUser = User::create($newUser);
            $newUser->assignRole($request->get('role'));
        } catch (\Exception $e) {
            Log::error($this->getLogMsg($e));
            return back()->withInput()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('users')->with('successMsg', 'User created!');
    }

    public function edit($userId)
    {
        $roles = Role::all();
        $user = User::findOrFail($userId);
        return view('backend.user_edit', compact('roles', 'user'));
    }

    public function update(UserRequest $request, $userId)
    {
        $newUser = $request->only('name', 'username', 'email');
        $newUser['is_active'] = $request->has('is_active');
        try {
            if ($request->has('password')) {
                $newUser['password'] = \Hash::make($request->get('password'));
            }
            $user = User::where('id', $userId)->first();
            $user->update($newUser);
            if ($request->has('role')) {
                $user->syncRoles(Role::where('name', $request->get('role'))->get());
            }
        } catch (\Exception $e) {
            Log::error($this->getLogMsg($e));
            return back()->with('errorMsg', $e->getMessage());
        }
        return redirect()->route('get-user', ['userId' => $userId])->with('successMsg', 'User updated');
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

    public function toggleActive($userId)
    {
        try {
            $user = User::find($userId);
            $user->update(['is_active' => !$user->is_active]);
        } catch (\Exception $e) {
            Log::error($this->getLogMsg($e));
            return back()->with('errorMsg', $this->getMessage($e));
        }
        return back()->with('successMsg', 'User updated successfully!');
    }
}

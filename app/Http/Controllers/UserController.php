<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Models\Address;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use League\Flysystem\Exception;

class UserController extends Controller
{
    public function index(Request $request){
        $users = User::with('roles')->get();
        return view('backend.userList', compact('users'));
    }

    public function show(Request $request, $userId){
        $user = User::find($userId);
        return view('backend.userDetails', compact('user'));
    }

    public function destroy(Request $request, $userId){
        if(Auth::user()->id == $userId){
            return redirect()->back()->with('errorMsg', 'You cannot delete yourself');
        }
        try{
            User::destroy($userId);
        }catch(\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->back()->with('successMsg', 'User deleted');
    }

    public function create(){
        $roles = Role::where('name', '!=', 'owner')->get();
        return view('backend.createUser', compact('roles'));
    }

    public function store(Request $request){
        $newUser = $request->only('title', 'name', 'username', 'email', 'password', 'website');
        $roleId = $request->get('role_id');
        $newAddress = $request->only('city', 'country');
        try{
            $newAddress = Address::create($newAddress);
            $newAddress['address_id'] = $newAddress->id;
            $newUser = User::create($newUser);
            $newUser->attachRole(Role::find($roleId));
        }catch (\Exception $e){
            return back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('users')->with('successMsg', 'User created successfully!');
    }

    public function edit(Request $request, $userId){
        $roles = Role::where('name', '!=', 'owner')->get();
        $user = User::findOrFail($userId);
        return view('backend.user_edit', compact('roles', 'user'));
    }

    public function update(Request $request){
        return $request->all();
    }

    public function changePassword(ChangePasswordRequest $request){
        $newPassword = $request->get('new_password');
        
        if(!Hash::check($request->get('old_password'), Auth::user()->password)) {
            return redirect()->back()->with('errorMsg', 'Unauthorized request');
        }
        try{
            User::where('id', Auth::user()->id)->update(['password' => Hash::make($newPassword)]);
        }catch (\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }

        return redirect()->back()->with('successMsg', 'Password changed');
    }
}

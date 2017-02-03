<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\Address;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users = User::with('roles')->get();
        return view('backend.userList', compact('users'));
    }

    public function show($userId){
        $user = User::find($userId);
        return view('backend.userDetails', compact('user'));
    }

    public function destroy($userId){
        if(Auth::user()->id == $userId){
            return back()->with('errorMsg', 'You cannot delete yourself');
        }
        try{
            User::destroy($userId);
        }catch(\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return back()->with('successMsg', 'User deleted');
    }

    public function create(){
        $roles = Role::where('name', '!=', 'owner')->get();
        return view('backend.user_create', compact('roles'));
    }

    public function store(UserRequest $request){
        $newUser = $request->only('title', 'name', 'username', 'email', 'website');
        $newUser['password'] = Hash::make($request->get('password'));
        $newAddress = $request->only('city', 'country_name');
        try{
            $newAddress = Address::create($newAddress);
            $newAddress['address_id'] = $newAddress->id;
            $newUser = User::create($newUser);
            $newUser->attachRole(Role::find($request->get('user_id')));
        }catch (\Exception $e){
            return back()->with('errorMsg', $this->getMessage($e))->withInput();
        }
        return redirect()->route('users')->with('successMsg', 'User created!');
    }

    public function edit($userId){
        $roles = Role::all();
        $user = User::findOrFail($userId);
        return view('backend.user_edit', compact('roles', 'user'));
    }

    public function update(UserRequest $request, $userId){
        $newUser = $request->only('name', 'username', 'email');
        if($request->has('password')){
            $newUser['password'] = \Hash::make($request->get('password'));
        }
        try{
            User::where('id', $userId)->update($newUser);
            //$user->attachRole(Role::where('name', 'author')->first());
        }catch (\Exception $e){
            return back()->with('errorMsg', $e->getMessage());
        }
        return redirect()->route('get-user', ['userId' => $userId])->with('successMsg', 'User updated');
    }

    public function changePassword(ChangePasswordRequest $request){
        $newPassword = $request->get('new_password');
        
        if(!Hash::check($request->get('old_password'), Auth::user()->password)) {
            return back()->with('errorMsg', 'Unauthorized request');
        }
        try{
            User::where('id', Auth::user()->id)->update(['password' => Hash::make($newPassword)]);
        }catch (\PDOException $e){
            return back()->with('errorMsg', $this->getMessage($e));
        }

        return back()->with('successMsg', 'Password changed');
    }

    public function profile(){
        $user = Auth::user();
        return view('backend.userDetails', compact('user'));
    }
}

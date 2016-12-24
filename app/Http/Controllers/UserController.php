<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request){
        $users = User::with('roles')->get();
        return view('backend.userList', compact('users'));
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

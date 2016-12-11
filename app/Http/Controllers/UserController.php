<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request){
        $users = User::with('role')->get();
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
}

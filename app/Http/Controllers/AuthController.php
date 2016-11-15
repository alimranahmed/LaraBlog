<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm(Request $request){
        return view('backend.auth');
    }

    public function login(Request $request){
        $this->validate($request, ['email' => 'required|email', 'password' => 'required|min:4']);

        if(Auth::attempt($request->only('email', 'password'))){
            return Auth::user();
        }else{
            return back()->with('auth_error','Invalid credentials');
        }
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect()->route('loginForm');
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm(){
        if(Auth::check()){
            return redirect()->route('admin-dashboard');
        }
        return view('backend.auth');
    }

    public function login(Request $request){
        $this->validate($request, ['email' => 'required|email', 'password' => 'required|min:4']);

        if(Auth::attempt($request->only('email', 'password'), $request->has('remember_me'))){
            return redirect()->route('admin-dashboard');
        }else{
            return back()->with('auth_error','Invalid credentials')->withInput();
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login-form');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin-dashboard');
        }
        return view('backend.auth');
    }

    public function login(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email',
                'password' => 'required|min:4'
            ]
        );

        $credentials = $request->only('email', 'password');

        $remember = $request->has('remember_me');

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->route('admin-dashboard');
        }

        return back()->with('auth_error', 'Invalid credentials')->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login-form');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm(Request $request){
        return view('backend.auth');
    }

    public function login(Request $request){

    }
}

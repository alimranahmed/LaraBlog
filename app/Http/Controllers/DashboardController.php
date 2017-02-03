<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        if(!Auth::check()){
            return redirect()->route('login');
        }
        return view('backend.dashboard');
    }
}

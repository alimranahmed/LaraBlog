<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request): RedirectResponse|View
    {
        if (Auth::check()) {
            return redirect()->route('admin-dashboard');
        } else {
            return (new ArticleController())->index($request);
        }
    }
}

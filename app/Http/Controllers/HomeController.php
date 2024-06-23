<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        if (Auth::check()) {
            $dashboard = new DashboardController();

            return $dashboard->index();
        } else {
            return (new ArticleController())->index($request);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ConfigController extends Controller
{
    public function index(): View
    {
        return view('backend.config.index');
    }
}

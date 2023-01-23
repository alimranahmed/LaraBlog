<?php

namespace App\Http\Controllers;

class ConfigController extends Controller
{
    public function index()
    {
        return view('backend.config.index');
    }
}

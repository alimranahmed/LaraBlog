<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index(){
        $configs = Config::all();
        return view('backend.configList', compact('configs'));
    }

    public function update(Request $request, $configId){

    }
}

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
        try{
            $updatedConfig = $request->only('value');
            Config::where('id', $configId)->update($updatedConfig);
        }catch (\Exception $e){
            return back()->with('errorMsg', $this->getMessage($e));
        }
        return back()->with('successMsg', 'Configuration updated');
    }
}

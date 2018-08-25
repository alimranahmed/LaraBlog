<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConfigController extends Controller
{
    public function index()
    {
        $configs = Config::all();
        return view('backend.configList', compact('configs'));
    }

    public function update(Request $request, $configId)
    {
        try {
            $updatedConfig = $request->only('value');
            Config::where('id', $configId)->update($updatedConfig);
        } catch (\Exception $e) {
            Log::error($this->getLogMsg($e));
            return back()->with('errorMsg', $this->getMessage($e));
        }
        return back()->with('successMsg', 'Configuration updated');
    }
}

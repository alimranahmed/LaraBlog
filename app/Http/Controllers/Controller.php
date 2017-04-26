<?php

namespace App\Http\Controllers;

use App\Helpers\HttpClient;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getMessage(\Exception $e, $msg = null){
        if(env('APP_ENV') == 'local'){
            return $e->getMessage();
        }else{
            return is_null($msg) ? 'Oops, operation failed please try again' : $msg;
        }
    }

    public function test(){
        $ip = "118.70.233.193";
        $httpClient = new HttpClient();
        $response = $httpClient->send("http://freegeoip.net/json/$ip");
        $location = json_decode($response->body);
        dd($response);
    }
}

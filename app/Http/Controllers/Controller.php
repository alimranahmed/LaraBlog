<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getMessage($e, $msg = null){
        if(env('APP_ENV') == 'local'){
            return $e->getMessage();
        }else{
            return is_null($msg) ? 'Oops, operation failed please try again' : $msg;
        }
    }
}

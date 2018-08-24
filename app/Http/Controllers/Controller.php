<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getMessage(\Exception $e, $msg = null)
    {
        if (env('APP_ENV') == 'local') {
            return $e->getLine() . ': ' . $e->getFile() . ' ' . $e->getMessage();
        } else {
            return is_null($msg) ? 'Oops, operation failed please try again' : $msg;
        }
    }

    public function test()
    {
    }
}

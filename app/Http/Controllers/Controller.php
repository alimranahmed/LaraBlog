<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $frontView;

    public function __construct()
    {
        $frontendDesign = config('blog.frontend_design');
        $this->frontView = "frontend.{$frontendDesign}";
    }

    public function getMessage(\Exception $e, $msg = null)
    {
        if ($e instanceof ValidationException) {
            return $e->getMessage();
        }

        if (env('APP_ENV') != 'production') {
            return $this->getLogMsg($e);
        } else {
            return is_null($msg) ? 'Oops, operation failed please try again' : $msg;
        }
    }

    public function getLogMsg(\Exception $e)
    {
        return $e->getLine() . ': ' . $e->getFile() . ' ' . $e->getMessage();
    }
}

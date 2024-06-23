<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Validation\ValidationException;

abstract class Controller
{
    protected string $frontView;

    public function __construct()
    {
        $frontendDesign = config('blog.frontend_design');
        $this->frontView = "frontend.$frontendDesign";
    }

    public function getMessage(Exception $e, $msg = null)
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

    public function getLogMsg(Exception $e): string
    {
        return $e->getLine().': '.$e->getFile().' '.$e->getMessage();
    }
}

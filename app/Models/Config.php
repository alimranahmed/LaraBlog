<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public static function get($name){
        $config = self::where('name', $name)->first();
        if(is_null($config)){
            return null;
        }
        return $config->value;
    }
}

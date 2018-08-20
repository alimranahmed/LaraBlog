<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $guarded = ['id'];

    public static function get($name)
    {
        $config = self::where('name', $name)->first();
        if (is_null($config)) {
            return null;
        }
        return $config->value;
    }

    public static function allFormatted($isActive = 1)
    {
        $configs = new \stdClass();
        $dbConfigs = self::where('is_active', $isActive)->get();
        foreach ($dbConfigs as $config) {
            $configs->{$config->name} = $config->value;
        }
        return $configs;
    }
}

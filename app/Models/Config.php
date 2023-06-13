<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use stdClass;

/**
 * @property string $name
 * @property string $value
 */
class Config extends Model
{
    protected $guarded = ['id'];

    public static function get($name): ?string
    {
        return self::query()->where('name', $name)->value('value');
    }

    public static function allFormatted($isActive = 1): stdClass
    {
        $configs = new stdClass();

        $dbConfigs = self::query()->where('is_active', $isActive)->get();

        $dbConfigs->each(fn (self $config) => $configs->{$config->name} = $config->value);

        return $configs;
    }
}

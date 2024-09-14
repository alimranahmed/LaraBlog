<?php

namespace App\Models;

use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use stdClass;

/**
 * @property string $name
 * @property string $value
 */
class Config extends Model
{
    public const FAVICON = 'favicon';

    public const USER_PHOTO = 'user_photo';

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

    public static function getPath(string $name): string
    {
        $defaultPath = match ($name) {
            self::FAVICON => asset('img/favicon.png'),
            self::USER_PHOTO => asset('img/user.png'),
        };

        if ($defaultPath == null) {
            throw new InvalidArgumentException('Invalid config name: '.$name);
        }

        $path = Config::query()->where('name', $name)->value('value');

        return $path ? route('file', [$name]) : asset($defaultPath);
    }
}

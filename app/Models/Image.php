<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $uuid
 * @property string $src
 */
class Image extends Model
{
    protected $guarded = ['id'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = ['id'];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}

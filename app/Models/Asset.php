<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $guarded = ['id'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    protected $guarded = ['id'];

    public function scopeVerified(Builder $builder): Builder
    {
        return $builder->where('is_verified', 1);
    }

    public function scopeSubscribed(Builder $builder): Builder
    {
        return $builder->where('notify', 1);
    }
}

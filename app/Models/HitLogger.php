<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HitLogger extends Model
{
    protected $guarded = ['id'];
    public function article(){
        return $this->belongsTo(Article::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    protected $guarded = ['id'];

    public function image(){
        return $this->belongsTo(Image::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = ['id'];

    protected function user(){
        return $this->belongsTo(User::class);
    }

    public function articles(){
        return $this->hasMany(Comment::class);
    }
}

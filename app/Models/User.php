<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id'];

    public function articles(){
        return $this->hasMany(Article::class);
    }

    public function image(){
        return $this->belongsTo(Image::class);
    }

    public function reader(){
        return $this->hasOne(Reader::class);
    }

    public function getIsReaderAttribute(){
        return !is_null($this->reader);
    }
}

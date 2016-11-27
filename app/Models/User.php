<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id'];
    protected $appends = ['createdAtHuman'];

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

    public function getCreatedAtHumanAttribute(){
        $carbonDate = new Carbon($this->created_at);
        return $carbonDate->diffForHumans();
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id'];

    public function article(){
        return $this->belongsTo(Article::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value){
        $carbonDate = new Carbon($value);
        return $carbonDate->diffForHumans();
    }
}

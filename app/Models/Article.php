<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = ['id'];

    protected function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class)->with('user')->orderBy('created_at', 'desc');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    //Written from the address
    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function images(){
        return $this->belongsToMany(Image::class, 'article_image');
    }

    public function keywords(){
        return $this->belongsToMany(Keyword::class, 'article_keyword');
    }

    public function getPublishedAtAttribute($value){
        $carbonDate = new Carbon($value);
        return $carbonDate->diffForHumans();
    }
}

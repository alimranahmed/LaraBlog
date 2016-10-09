<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = ['id'];

    protected function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'article_category');
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function addresses(){
        return $this->belongsToMany(Image::class, 'article_image');
    }
}

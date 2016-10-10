<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    public function articles(){
        return $this->belongsToMany(Article::class, 'article_keyword');
    }
}

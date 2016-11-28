<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $guarded = ['id'];

    public function articles(){
        return $this->belongsToMany(Article::class, 'article_keyword');
    }

    public function getCreatedAtHumanAttribute(){
        $createdAt = new Carbon($this->created_at);
        return $createdAt->diffForHumans(Carbon::now());
    }
}

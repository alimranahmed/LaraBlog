<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];
    public function articles(){
        return $this->hasMany(Article::class);
    }

    public function parent(){
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    public function children(){
        return $this->belongsTo(Category::class, 'parent_category_id');
    }
}

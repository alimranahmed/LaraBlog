<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Category extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    protected $appends = ['createdAtHuman'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function parent()
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    public function children()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    public function getCreatedAtHumanAttribute()
    {
        $carbonDate = new Carbon($this->updated_at);
        return $carbonDate->diffForHumans();
    }

    public static function getNonEmptyOnly(): Collection
    {
        return Category::whereHas('articles')->active()->get();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Keyword extends Model
{
    protected $guarded = ['id'];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_keyword');
    }

    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * @param Collection $keywords
     * @return array
     */
    public static function getArticleIDs(Collection $keywords)
    {
        $articleKeywords = DB::table('article_keyword')
            ->select('article_id', 'keyword_id')
            ->whereIn('keyword_id', $keywords->pluck('id')->toArray())
            ->get();
        return $articleKeywords->pluck('article_id')->toArray();
    }
}

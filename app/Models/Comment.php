<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    use CanFormatDates;

    protected $guarded = ['id'];
    protected $dates = ['published_at'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }

    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    public function scopePublished(Builder $builder)
    {
        return $builder->where('is_published', 1);
    }

    public function scopeNoReplies(Builder $builder)
    {
        return $builder->where('parent_comment_id', null);
    }
}

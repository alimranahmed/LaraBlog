<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** @property string $content
 * @property ?string $original_content
 * @property int $count_edit
 */
class Comment extends Model
{
    use CanFormatDates;
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['published_at' => 'datetime'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }

    public function parentComment(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    public function scopePublished(Builder $builder): Builder
    {
        return $builder->where('is_published', 1);
    }

    public function scopeNoReplies(Builder $builder): Builder
    {
        return $builder->where('parent_comment_id', null);
    }
}

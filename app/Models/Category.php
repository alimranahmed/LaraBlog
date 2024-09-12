<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property string|int $id
 */
class Category extends Model
{
    use CanFormatDates;
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = ['createdAtHumanDiff'];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    public function children(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    public static function getNonEmptyOnly(): Collection
    {
        return Category::query()->whereHas('articles')->active()->get();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}

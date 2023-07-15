<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\LaravelMarkdown\MarkdownRenderer;

/**
 * @property string $category
 * @property int $user_id
 * @property string $content
 * @property array $meta
 * @property string $id
 * @property \Illuminate\Support\Collection $keywords
 */
class Article extends Model
{
    use HasFactory;
    use CanFormatDates;

    protected $guarded = ['id'];

    protected $casts = ['published_at' => 'datetime', 'meta' => 'json'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)
            ->with('user')
            ->orderBy('id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'article_image');
    }

    public function keywords(): BelongsToMany
    {
        return $this->belongsToMany(Keyword::class, 'article_keyword');
    }

    public function scopeNotDeleted(Builder $builder): Builder
    {
        return $builder->where('is_deleted', 0);
    }

    public function scopePublished(Builder $builder): Builder
    {
        return $builder->where('is_published', 1);
    }

    public function categoryName(): Attribute
    {
        return Attribute::make(
            get: fn () => optional($this->category)->name
        );
    }

    public function htmlContent(): Attribute
    {
        return Attribute::make(
            get: fn () => app(MarkdownRenderer::class)
                ->disableHighlighting()
                ->toHtml($this->content)
        );
    }

    public function hasAuthorization(User $user): bool
    {
        return $user->hasRole(['author']) && $this->user_id != $user->id;
    }

    public function scopeSearch(Builder $builder, $query = ''): Builder
    {
        if ($query) {
            return $builder->where(function (Builder $builder) use ($query) {
                return $builder->where('heading', 'like', "%$query%")
                    ->orWhere('content', 'content', "%$query%");
            });
        }

        return $builder;
    }

    public static function getPaginated(?Request $request = null): LengthAwarePaginator
    {
        $perPage = config('blog.item_per_page');

        $categoryAlias = optional($request)->route('categoryAlias');
        $keywordName = optional($request)->route('keywordName');

        if (! is_null($categoryAlias)) {
            $category = Category::query()->where('alias', $categoryAlias)->first();
            if (is_null($category)) {
                return new LengthAwarePaginator(collect(), 0, $perPage);
            }
            $articleQuery = Article::query()->where('category_id', $category->id);
        } elseif (! is_null($keywordName)) {
            $keyword = Keyword::query()->where('name', $keywordName)->first();
            if (is_null($keyword)) {
                return new LengthAwarePaginator(collect(), 0, $perPage);
            }
            $articleIds = $keyword->articles->pluck('id')->toArray();
            $articleQuery = Article::query()->whereIn('id', $articleIds);
        } else {
            $articleQuery = Article::query()->published()->notDeleted();
        }

        $paginateUrl = '';
        if (optional($request)->has('lang')) {
            $articleQuery = $articleQuery->where('language', $request->lang);
            $paginateUrl = '?lang='.$request->lang;
        }

        return $articleQuery->with('category', 'keywords', 'user')
            ->latest()
            ->paginate($perPage)
            ->withPath($paginateUrl);
    }
}

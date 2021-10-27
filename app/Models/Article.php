<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use League\CommonMark\CommonMarkConverter;

class Article extends Model
{
    use HasFactory;
    use CanFormatDates;

    protected $guarded = ['id'];
    protected $dates = ['published_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->with('user')->orderBy('id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'article_image');
    }

    public function keywords()
    {
        return $this->belongsToMany(Keyword::class, 'article_keyword');
    }

    public function scopeNotDeleted(Builder $builder)
    {
        return $builder->where('is_deleted', 0);
    }

    public function scopePublished(Builder $builder)
    {
        return $builder->where('is_published', 1);
    }

    public function getCategoryNameAttribute()
    {
        return optional($this->category)->name;
    }

    public function getContentAsHtmlAttribute()
    {
        $converter = new CommonMarkConverter();
        echo $converter->convertToHtml($this->content);
    }

    public function hasAuthorization(User $user)
    {
        return $user->hasRole(['author']) && $this->user_id != $user->id;
    }

    public function scopeSearch(Builder $builder, $query = '')
    {
        if ($query) {
            return $builder->where(function (Builder $builder) use ($query) {
                return $builder->where('heading', 'like', "%{$query}%")
                    ->orWhere('content', 'content', "%{$query}%");
            });
        }
        return $builder;
    }

    public static function getPaginated(?Request $request = null): LengthAwarePaginator
    {
        $perPage = config('blog.item_per_page');

        $categoryAlias = optional($request)->route('categoryAlias');
        $keywordName = optional($request)->route('keywordName');

        if (!is_null($categoryAlias)) {
            $category = Category::where('alias', $categoryAlias)->first();
            if (is_null($category)) {
                return new LengthAwarePaginator(collect([]), 0, $perPage);
            }
            $articleQuery = Article::where('category_id', $category->id);
        } elseif (!is_null($keywordName)) {
            $keyword = Keyword::where('name', $keywordName)->first();
            if (is_null($keyword)) {
                return new LengthAwarePaginator(collect([]), 0, $perPage);
            }
            $articleIds = $keyword->articles->pluck('id')->toArray();
            $articleQuery = Article::whereIn('id', $articleIds);
        } else {
            $articleQuery = Article::published()->notDeleted();
        }

        $paginateUrl = '';
        if (optional($request)->has('lang')) {
            $articleQuery = $articleQuery->where('language', $request->lang);
            $paginateUrl = '?lang=' . $request->lang;
        }

        return $articleQuery->with('category', 'keywords', 'user')
            ->latest()
            ->paginate($perPage)
            ->withPath($paginateUrl);
    }
}

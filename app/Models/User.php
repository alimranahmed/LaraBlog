<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 */
class User extends Authenticatable
{
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use CanFormatDates;

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $guarded = ['id'];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function reader(): HasOne
    {
        return $this->hasOne(Reader::class);
    }

    public function isReader(): bool
    {
        return ! is_null($this->reader);
    }

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('is_active', 1);
    }

    public static function getSubscribedUsers(): Collection
    {
        $subscribedReadersIds = Reader::query()
            ->subscribed()
            ->verified()
            ->pluck('user_id');

        return self::query()->whereIn('id', $subscribedReadersIds)->get();
    }
}

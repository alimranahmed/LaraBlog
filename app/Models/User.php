<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use CanFormatDates;

    protected $guarded = ['id'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function reader()
    {
        return $this->hasOne(Reader::class);
    }

    public function isReader()
    {
        return !is_null($this->reader);
    }

    public function scopeActive(Builder $builder)
    {
        return $builder->where('is_active', 1);
    }

    public static function getSubscribedUsers()
    {
        $subscribedReadersIds = Reader::subscribed()
            ->verified()
            ->pluck('user_id');
        return self::whereIn('id', $subscribedReadersIds)->get();
    }
}

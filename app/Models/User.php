<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    protected $guarded = ['id'];
    protected $appends = ['createdAtHuman'];

    public function articles(){
        return $this->hasMany(Article::class);
    }

    public function image(){
        return $this->belongsTo(Image::class);
    }

    public function reader(){
        return $this->hasOne(Reader::class);
    }

    /*public function role(){
        return $this->belongsTo(Role::class);
    }*/

    public function getIsReaderAttribute(){
        return !is_null($this->reader);
    }

    public function getCreatedAtHumanAttribute(){
        $carbonDate = new Carbon($this->created_at);
        return $carbonDate->diffForHumans();
    }

    public static function getSubscribedUsers(){
        $subscribedReadersIds = Reader::where('notify', 1)->pluck('user_id')->toArray();
        $users = self::whereIn('id',$subscribedReadersIds)->get();
        return $users;
    } 
}

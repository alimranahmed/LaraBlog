<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $guarded = ['id'];
    protected $appends = ['createdAtHuman'];

    public function getCreatedAtHumanAttribute()
    {
        $carbonDate = new Carbon($this->created_at);
        return $carbonDate->diffForHumans();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use CanFormatDates;

    protected $table = 'feedbacks';
    protected $guarded = ['id'];
}

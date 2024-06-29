<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use CanFormatDates;
    use HasFactory;

    protected $table = 'feedbacks';

    protected $guarded = ['id'];
}

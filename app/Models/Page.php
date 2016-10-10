<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function assets(){
        return $this->hasMany(Asset::class);
    }
}

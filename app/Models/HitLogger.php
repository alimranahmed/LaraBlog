<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HitLogger extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['country', 'city'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function getCountryAttribute()
    {
        return empty($this->address->country_name) ? 'Unknown' : $this->address->country_name;
    }

    public function getCityAttribute()
    {
        return empty($this->address->city) ? 'Unknown' : $this->address->city;
    }
}

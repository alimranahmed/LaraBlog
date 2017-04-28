<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HitLogger extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['country', 'city'];
    public function article(){
        return $this->belongsTo(Article::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function getCountryAttribute(){
        return isset($this->address->country_name) ? $this->address->country_name : 'Unknown';
    }

    public function getCityAttribute(){
        return isset($this->address->city) ? $this->address->city : 'Unknown';
    }
}

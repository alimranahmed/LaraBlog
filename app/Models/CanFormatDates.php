<?php


namespace App\Models;

trait CanFormatDates
{
    public function getCreatedAtHumanDiffAttribute()
    {
        return optional($this->created_at)->diffForHumans();
    }

    public function getCreatedDateTimeFormattedAttribute()
    {
        return optional($this->created_at)->format('M d, Y h:i A');
    }

    public function getUpdatedAtHumanDiffAttribute()
    {
        return optional($this->updated_at)->diffForHumans();
    }

    public function getPublishedAtHumanDiffAttribute()
    {
        return optional($this->published_at)->diffForHumans();
    }

    public function getPublishedDateFormattedAttribute()
    {
        return optional($this->published_at)->format('M d, Y');
    }

    public function getPublishedDateTimeFormattedAttribute()
    {
        return optional($this->published_at)->format('M d, Y h:i A');
    }
}

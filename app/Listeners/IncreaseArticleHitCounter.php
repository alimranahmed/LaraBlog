<?php

namespace App\Listeners;

use App\Events\ArticleHit;
use App\Models\Address;
use App\Models\HitLogger;

class IncreaseArticleHitCounter
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ArticleHit $event
     * @return void
     */
    public function handle(ArticleHit $event)
    {
        $article = $event->article;
        $clientIP = $event->clientIP;

        $address = Address::firstOrCreate(['ip' => $clientIP]);

        $hitLogger = HitLogger::where(['article_id' => $article->id, 'address_id' => $address->id])->first();

        if (is_null($hitLogger)) {
            HitLogger::create(['article_id' => $article->id, 'address_id' => $address->id, 'count' => 1]);
            $article->increment('hit_count');
        } else {
            $hitLogger->increment('count');
        }
    }
}

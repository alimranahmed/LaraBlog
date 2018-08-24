<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArticleHit
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Article
     */
    public $article;

    public $clientIP;

    /**
     * Create a new event instance.
     *
     * @param Article $article
     * @param string $clientIP
     */
    public function __construct(Article $article, string $clientIP)
    {
        $this->article = $article;
        $this->clientIP = $clientIP;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

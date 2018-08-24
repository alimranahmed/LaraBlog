<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Pusher;

class CommentOnArticle implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
        $this->broadcastToPusher();
    }

    private function broadcastToPusher()
    {
        $options = [
            'encrypted' => true
        ];
        $pusher = new Pusher(
            env('PUSHER_KEY'),
            env('PUSHER_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data['message'] = $this->message;
        $pusher->trigger('visitor-activity', 'comment', $data);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('visitor-activity');
    }

    public function broadcastAs()
    {
        return 'comment-on-article';
    }
}

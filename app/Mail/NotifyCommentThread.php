<?php

namespace App\Mail;

use App\Models\Comment;
use App\Models\Config;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyCommentThread extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;

    /**
     * NotifyCommentThread constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Config::get('admin_email'), Config::get('site_name'))
            ->subject('Response on the comment thread you are following')
            ->view('emails.comment_thread_notification');
    }
}

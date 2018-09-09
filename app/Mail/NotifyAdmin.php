<?php

namespace App\Mail;

use App\Models\Comment;
use App\Models\Config;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    public $url;

    /**
     * Create a new message instance.
     *
     * @param $comment
     * @param $url
     */
    public function __construct($comment, $url)
    {
        $this->comment = $comment;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Config::get('admin_email'), Config::get('site_name'))
            ->subject('User response in your Blog')
            ->view('emails.notify_admin');
    }
}

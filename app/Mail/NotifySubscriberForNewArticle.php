<?php

namespace App\Mail;

use App\Models\Config;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifySubscriberForNewArticle extends Mailable
{
    use Queueable, SerializesModels;

    public $article;

    public $user;

    /**
     * Create a new message instance.
     *
     * @param $article
     * @param $user
     */
    public function __construct($article, $user)
    {
        $this->article = $article;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Config::get('admin_email'), Config::get('site_name'))
            ->subject("New article Published")
            ->view('emails.notify_new_article');
    }
}

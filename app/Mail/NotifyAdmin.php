<?php

namespace App\Mail;

use App\Models\Config;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $msg;
    public $url;

    /**
     * Create a new message instance.
     *
     * @param $msg
     * @param $url
     */
    public function __construct($msg, $url)
    {
        $this->msg = $msg;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Config::get('admin_email'))
            ->subject('User response in your Blog')
            ->view('emails.notify_admin');
    }
}

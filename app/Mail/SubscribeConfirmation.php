<?php

namespace App\Mail;

use App\Models\Config;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscribeConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Config::get('admin_email'), Config::get('site_name'))
            ->subject('Confirm Your Subscription')
            ->view('emails.subscribe_confirmation');
    }
}

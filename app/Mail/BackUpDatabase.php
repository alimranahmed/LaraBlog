<?php

namespace App\Mail;

use App\Models\Config;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BackUpDatabase extends Mailable
{
    use Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function build()
    {
        return $this->from(Config::get('admin_email'), Config::get('site_name'))
            ->subject('Database backup for blog')
            ->view('emails.backup_database')
            ->attach($this->filePath);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class AdminSendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content, $subject)
    {
        $this->content = $content;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->subject($this->subject)
        ->view('admin.emails.send_mail_format')
        ->with(['content' => $this->content]);
    }
}

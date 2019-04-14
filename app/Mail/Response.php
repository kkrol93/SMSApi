<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Response extends Mailable
{
    use Queueable, SerializesModels;
    public $account;
    public $recipient;
    public $response;
    public $ip;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($account, $recipient, $response, $ip)
    {

        $this->subject('SMS API System Error');
        $this->account = $account;
        $this->recipient = $recipient;
        $this->response = $response;
        $this->ip = $ip;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.response', compact('account', 'recipient', 'response', 'ip'));
    }
}

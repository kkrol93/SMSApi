<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;

use Illuminate\Queue\SerializesModels;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ResponseServer
{
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->CharSet = "UTF-8";
        $this->mail->isSMTP();                                      // Set mailer to use SMTP
        $this->mail->Host = env('MAIL_HOST');  // Specify main and backup server
        $this->mail->SMTPAuth = env('MAIL_SMTP_AUTH');                         // Enable SMTP authentication
        $this->mail->Username = env('MAIL_USERNAME');                            // SMTP username
        $this->mail->Password = env('MAIL_PASSWORD');                    // SMTP password
        $this->mail->SetFrom(env('MAIL_FROM'), env('MAIL_NAME'));
        $this->mail->SMTPSecure = env('MAIL_ENCRYPTION');                            // Enable TLS encryption, `ssl` also accepted
        $this->mail->Port = env('MAIL_PORT');
        $this->mail->addAddress("krzysztofkrolm8@gmail.com", "Recepient Name");
        $this->mail->Body = "<i>Mail body in HTML</i>";
        $this->mail->Subject = "Subject Text";
    }

    public function setSubject()
    {
        $this->mail->Subject = 'SMS API System Error';
    }

    public function setBody($request)
    {
        $body = $request;
        $this->mail->msgHTML($body);
    }

    public function addAddress($mailAddress, $addressee = '')
    {
        $this->mail->addAddress($mailAddress, $addressee);
    }

    public function getEml()
    {
        $this->mail->preSend();
        return $this->mail->getSentMIMEMessage();
    }

    public function addAddresses($addresses)
    {
        foreach ($addresses as $address) {
            $this->mail->addAddress($address);
        }
    }


    public function send()
    {
        if (env('MAIL_DRIVER') == 'log') {
            \Log::info($this->body);
            return 'success';
        }
        if ($this->mail->send()) {
            return 'success';
        }


        return $this->mail->ErrorInfo;
    }
    // public function build()
    // {
    //     return $this->view('mails.server', compact('request'));
    // }
}

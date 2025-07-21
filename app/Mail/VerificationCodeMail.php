<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $msg_data;

    public function __construct($msg_data)
    {
        $this->msg_data = $msg_data;
      
    }

    public function build()
    {
        return $this->subject('Verification Code Mail Message :: ')
                    ->view('usermodule::emails.VerificationCodeMail')
                    ->with('msg_data', $this->msg_data);
    }
}

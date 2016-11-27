<?php

namespace Lezhnev74\EmailVerifierLaravel\Laravel\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserNeedsVerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $link;


    public function __construct(string $verification_link)
    {
        $this->link = $verification_link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email-verifier-laravel::verification-email', ['link' => $this->link]);
    }
}

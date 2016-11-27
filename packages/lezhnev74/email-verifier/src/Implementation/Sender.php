<?php

namespace Lezhnev74\EmailVerifierLaravel\Implementation;

use Lezhnev74\EmailVerifierLaravel\Laravel\Mail\UserNeedsVerifyEmail;
use Mail;
use Lezhnev74\EmailVerifier\Data\Email;
use Lezhnev74\EmailVerifier\Service\EmailSender;

class Sender implements EmailSender
{
    public function sendVerificationCodeToEmail(string $code, Email $email)
    {
        $mailable = new \stdClass();
        $mailable->email = $email->getEmail();

        $link = route('email-verify-url', ['code' => base64_encode($code), 'email' => $email->getEmail()]);

        Mail::to($mailable)->send(new UserNeedsVerifyEmail($link));
    }

}
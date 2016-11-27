<?php

namespace Lezhnev74\EmailVerifierLaravel\Implementation;

use Hash;
use Lezhnev74\EmailVerifier\Data\Email;
use Lezhnev74\EmailVerifier\Service\EmailCodeHasher;
use Lezhnev74\EmailVerifier\Service\EmailCodeVerifier;

class Verifier implements EmailCodeVerifier
{
    private $hasher;

    public function __construct(EmailCodeHasher $hasher)
    {
        $this->hasher = $hasher;
    }

    function verifyCodeFromEmail(string $code, Email $email): bool
    {
        $hashed_email = $this->hasher->makeCodeForEmail($email);

        // Ref: http://php.net/manual/en/function.hash-hmac.php#111435
        return md5($code) === md5($hashed_email);
    }

}
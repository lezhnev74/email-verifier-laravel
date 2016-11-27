<?php

namespace Lezhnev74\EmailVerifierLaravel\Implementation;

use Crypt;
use Lezhnev74\EmailVerifier\Data\Email;
use Lezhnev74\EmailVerifier\Service\EmailCodeHasher;

class Hasher implements EmailCodeHasher
{

    private $salt;

    public function __construct(string $salt)
    {
        $this->salt = $salt;
    }


    public function makeCodeForEmail(Email $email): string
    {
        return hash_hmac('sha256', $email->getEmail(), $this->salt);
    }

}
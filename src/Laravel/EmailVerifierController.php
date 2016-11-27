<?php
namespace Lezhnev74\EmailVerifierLaravel\Laravel;

use App\Http\Controllers\Controller;
use Lezhnev74\EmailVerifier\Data\Email;
use Lezhnev74\EmailVerifier\Service\VerifyEmailCode;

class EmailVerifierController extends Controller
{

    public function verify($code, $email, VerifyEmailCode $verifier)
    {

        // verify Email and Code
        $verifier->verify(base64_decode($code), new Email($email));

        // Always return OK
        return "OK";
    }

}
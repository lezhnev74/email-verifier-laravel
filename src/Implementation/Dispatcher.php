<?php

namespace Lezhnev74\EmailVerifierLaravel\Implementation;

use Lezhnev74\EmailVerifier\Event\EmailVerified;
use Lezhnev74\EmailVerifier\Service\EventDispatcher;

class Dispatcher implements EventDispatcher
{
    public function fireEmailVerified(EmailVerified $event)
    {
        event($event);
    }

}
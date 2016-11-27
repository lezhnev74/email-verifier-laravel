<?php

namespace Lezhnev74\EmailVerifierLaravel\Laravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Lezhnev74\EmailVerifier\Data\Email;
use Lezhnev74\EmailVerifier\Service\SendVerificationEmail;

class SendVerificationEmailToUser implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $email)
    {
        $this->email = new Email($email);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $service = app(SendVerificationEmail::class, [$this->email]);
        $service->send();

    }
}

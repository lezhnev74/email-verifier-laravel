<?php

class PackageTest extends TestCase
{

    public function test_verification_email_is_sent()
    {
        \Mail::fake();

        $email = new \Lezhnev74\EmailVerifier\Data\Email("example@example.org");
        $service = app(\Lezhnev74\EmailVerifier\Service\SendVerificationEmail::class);
        $service->send($email);

        // Assert
        $user = new stdClass();
        $user->email = $email->getEmail();
        \Mail::assertSentTo([$user], \Lezhnev74\EmailVerifierLaravel\Laravel\Mail\UserNeedsVerifyEmail::class);

    }

    public function test_event_is_fired_after_successfull_verification()
    {

        $this->expectsEvents([
            \Lezhnev74\EmailVerifier\Event\EmailVerified::class
        ]);

        $email = new \Lezhnev74\EmailVerifier\Data\Email("example@example.org");
        $code = app(\Lezhnev74\EmailVerifier\Service\EmailCodeHasher::class)->makeCodeForEmail($email);

        $service = app(\Lezhnev74\EmailVerifier\Service\VerifyEmailCode::class);
        $service->verify($code, $email);


    }


    public function test_flow()
    {
        $this->expectsEvents([
            \Lezhnev74\EmailVerifier\Event\EmailVerified::class
        ]);
        \Mail::fake();

        // 1. Detect which email to validate
        $email = new \Lezhnev74\EmailVerifier\Data\Email("example@example.org");

        // 2. Send verification email to the user
        $service = app(\Lezhnev74\EmailVerifier\Service\SendVerificationEmail::class);
        $service->send($email);

        // Assert
        $user = new stdClass();
        $user->email = $email->getEmail();

        // 3. Extract the link from the sent email
        \Mail::assertSent(\Lezhnev74\EmailVerifierLaravel\Laravel\Mail\UserNeedsVerifyEmail::class, function ($mail) {

            $verification_link = $mail->getLink();
            $relative_url = parse_url($verification_link, PHP_URL_PATH);

            // 4. Follow the link (will emit the event)
            $this->get($relative_url);

            return true;
        });

    }
}

<?php

namespace Lezhnev74\EmailVerifierLaravel\Laravel;

use Illuminate\Support\ServiceProvider;
use Lezhnev74\EmailVerifier\Service\EmailCodeHasher;
use Lezhnev74\EmailVerifier\Service\EmailCodeVerifier;
use Lezhnev74\EmailVerifier\Service\EmailSender;
use Lezhnev74\EmailVerifier\Service\EventDispatcher;
use Lezhnev74\EmailVerifierLaravel\Implementation\Dispatcher;
use Lezhnev74\EmailVerifierLaravel\Implementation\Hasher;
use Lezhnev74\EmailVerifierLaravel\Implementation\Sender;
use Lezhnev74\EmailVerifierLaravel\Implementation\Verifier;

class EmailVerifierServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'email-verifier-laravel');
        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/email-verifier-laravel'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/routes.php';
        $this->app->make('Lezhnev74\EmailVerifierLaravel\Laravel\EmailVerifierController');

        $this->app->bind(EmailCodeHasher::class, function () {
            return new Hasher(env('APP_KEY'));
        });
        $this->app->bind(EmailCodeVerifier::class, function () {
            $hasher = $this->app->make(EmailCodeHasher::class);
            return $this->app->make(Verifier::class, [$hasher]);
        });
        $this->app->bind(EventDispatcher::class, function () {
            return new Dispatcher();
        });
        $this->app->bind(EmailSender::class, function () {
            return new Sender();
        });
    }
}

<?php
\Route::get('verify-email-by-code/{code}/{email}',
    ['uses'=>'Lezhnev74\EmailVerifierLaravel\Laravel\EmailVerifierController@verify', 'as'=>'email-verify-url']
    );
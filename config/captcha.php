<?php

////////////////////////////////////////////////////////////////
//// STATAMIC CAPTCHA!!                                     ////
//// https://github.com/aryehraber/statamic-captcha         ////
////////////////////////////////////////////////////////////////

return [
    'service' => 'Turnstile', // options: Recaptcha / Hcaptcha / Turnstile
    'sitekey' => env('TURNSTILE_SITE_KEY', ''),
    'secret' => env('TURNSTILE_SECRET_KEY', ''),
    'collections' => [],
    'forms' => 'all',
    'user_login' => false,
    'user_registration' => false,
    'disclaimer' => '',
    'invisible' => false,
    'hide_badge' => false,
    'enable_api_routes' => false,
];

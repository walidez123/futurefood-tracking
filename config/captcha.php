<?php
/*
 * Secret key and Site key get on https://www.google.com/recaptcha
 * */
return [
    // 'secret' => env('CAPTCHA_SECRET', 'default_secret'),
    // 'sitekey' => env('CAPTCHA_SITEKEY', 'default_sitekey'),
    'secret' => env('RECAPTCHA_SECRET_KEY', '6LfK2_AZAAAAAHT8S2vWSm514yzD0OEZKb_WmcK0'),
    'sitekey' => env('RECAPTCHA_SITE_KEY', '6LfK2_AZAAAAAPFjev-gXWfe2HYxFIEalV53U3Hg'),

    /**
     * @var string|null Default ``null``.
     *                  Custom with function name (example customRequestCaptcha) or class@method (example \App\CustomRequestCaptcha@custom).
     *                  Function must be return instance, read more in repo ``https://github.com/thinhbuzz/laravel-google-captcha-examples``
     */
    'request_method' => null,
    'options' => [
        'multiple' => false,
        'lang' => app()->getLocale(),
    ],
    'attributes' => [
        'theme' => 'light',
    ],
];

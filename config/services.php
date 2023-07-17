<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
//    'facebook' => [
//        'client_id' => '5875762539191029',
//        'client_secret' => '9912f20fd96d69a919e4371336ff7a0b',
//        'redirect' => env('APP_URL').'/user/login/callback',
//    ],
    'google' => [
        'client_id' => '162872207327-tmi81rj44cq1r6a31lvhia5edltc8bcv.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => env('APP_URL').'/auth/google/callback',
    ],

];

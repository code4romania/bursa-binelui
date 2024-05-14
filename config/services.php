<?php

declare(strict_types=1);

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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'eu_platesc' => [
        'test_mode' => env('EU_PLATESC_TEST_MODE', true),
        'url' => env('EU_PLATESC_URL', 'https://secure.euplatesc.ro/tdsprocess/tranzactd.php'),
        'merchant_id' => env('EU_PLATESC_MERCHANT_ID', ''),
        'private_key' => env('EU_PLATESC_PRIVATE_KEY', ''),
    ],

    'google_maps_api_key' => env('GOOGLE_MAPS_API_KEY'),

    'google_recaptcha' => [
        'url' => 'https://www.google.com/recaptcha/api/siteverify',
        'site_key' => env('GOOGLE_RECAPTCHA_SITE_KEY'),
        'secret_key' => env('GOOGLE_RECAPTCHA_SECRET_SITE_KEY'),
        'threshold' => max(0.0, min(1.0, floatval(env('GOOGLE_RECAPTCHA_THRESHOLD', 0.5)))),
    ],

    'google_analytics' => [
        'tracking_id' => env('GOOGLE_ANALYTICS_TRACKING_ID', ''),
    ],
];

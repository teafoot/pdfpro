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
    'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'trial_period_days' => env('STRIPE_TRIAL_PERIOD_DAYS', 7),
    ],
    'lemonsqueezy' => [
        'base_url' => 'https://api.lemonsqueezy.com/v1',
        'key' => env('LEMON_SQUEEZY_API_KEY'),
        'store' => env('LEMON_SQUEEZY_STORE')
    ],
    'openai' => [
        'key' => env('OPENAI_KEY'),
        'urls' => [
            'base' => 'https://api.openai.com/v1/',
            'completion' => 'chat/completions',
            'images' => 'images/generations',
            'text-to-speech' => 'audio/speech'
        ],
        'models' => [
            'gpt4' => 'gpt-4-1106-preview',
            'gpt3.5' => 'gpt-3.5-turbo',
            'dalle' => 'dall-e-3',
            'tts-1' => 'tts-1'
        ],
    ],
];

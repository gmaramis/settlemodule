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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'fonnte' => [
        'token' => env('FONNTE_API_TOKEN'),
        'url' => env('FONNTE_API_URL', 'https://api.fonnte.com/send'),
        'admin_number' => env('ADMIN_WHATSAPP_NUMBER'),
    ],

    'whatsapp' => [
        'rate_limit' => [
            'per_minute' => env('WHATSAPP_RATE_LIMIT_PER_MINUTE', 10),
            'per_hour' => env('WHATSAPP_RATE_LIMIT_PER_HOUR', 100),
            'per_day' => env('WHATSAPP_RATE_LIMIT_PER_DAY', 500),
        ],
        'retry' => [
            'max_attempts' => env('WHATSAPP_MAX_RETRIES', 3),
            'backoff_multiplier' => env('WHATSAPP_BACKOFF_MULTIPLIER', 2),
        ],
        'timeout' => [
            'connect' => env('WHATSAPP_CONNECT_TIMEOUT', 10),
            'read' => env('WHATSAPP_READ_TIMEOUT', 30),
        ],
    ],

];

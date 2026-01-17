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
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
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

    'n8n' => [
        'api_key' => env('N8N_API_KEY'),
        'form_url' => env('N8N_FORM_URL', 'https://n8n.linn.games/webhook/5dd82489-f71f-4c10-97aa-564fb844ec2d/n8n-form'),
        'chat_url' => env('N8N_CHAT_URL', 'https://n8n.linn.games/webhook/5dd82489-f77f-4c10-97aa-564fb844ec2d/chat'),
        // REST API configuration
        'api_url' => env('N8N_API_URL'),
        'api_token' => env('N8N_API_TOKEN'),
    ],

];

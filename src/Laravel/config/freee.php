<?php

return [
    'api' => [
        'client_id'     => env('FREEE_CLIENT_ID'),
        'client_secret' => env('FREEE_CLIENT_SECRET'),
    ],
    'webhook' => [
        'verification_token' => env('FREEE_VERIFICATION_TOKEN'),
        'logging'            => env('FREEE_WEBHOOK_LOGGING', false),
    ],
];

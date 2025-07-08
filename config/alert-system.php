<?php

return [
    'telegram' => [
        'bots' => [
            'my_bot' => [
                'token' => env('TELEGRAM_ALERTS_BOT_TOKEN'),
                'proxy' => env('TELEGRAM_ALERTS_PROXY', null),
                'verify' => env('TELEGRAM_ALERTS_VERIFY', true),
            ]
        ],
        'default' => 'my_bot',
    ],
    'envs' => ["production"],
    'layout' => 'layouts.app',
    'db-history' => true,
    'logging' => [
        'enabled' => true,
        'channel' => 'daily',
        'level' => 'info',
    ]
];

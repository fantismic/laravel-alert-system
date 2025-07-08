<?php

return [
    'telegram' => [
        'token' => env('TELEGRAM_BOT_TOKEN'),
        'proxy' => env('TELEGRAM_PROXY',null),
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

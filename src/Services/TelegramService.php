<?php

namespace Fantismic\AlertSystem\Services;

use GuzzleHttp\Client;

class TelegramService
{
    protected Client $client;
    protected string $token;

    public function __construct()
    {
        $this->token = config('alert-system.telegram.token');

        $guzzleConfig = [
            'base_uri' => "https://api.telegram.org/bot{$this->token}/",
            'timeout'  => 5.0,
            'verify'   => false
        ];

        // Optional proxy support
        if ($proxy = config('alert-system.telegram.proxy')) {
            $guzzleConfig['proxy'] = $proxy;
        }

        $this->client = new Client($guzzleConfig);
    }

    public function sendMessage(string $chatId, string $message, string $botKey = 'default'): void
    {
        $botConfig = config("alert-system.telegram_bots.$botKey", config('alert-system.telegram_bots.default'));
        $token = $botConfig['token'];
        $proxy = $botConfig['proxy'] ?? null;
        $verify = $botConfig['verify'] ?? true;

        $client = new \GuzzleHttp\Client([
            'base_uri' => "https://api.telegram.org/bot{$token}/",
            'verify' => $verify,
            'proxy' => $proxy,
        ]);

        $client->post('sendMessage', [
            'json' => [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ],
        ]);
    }

}

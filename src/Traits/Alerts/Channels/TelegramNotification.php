<?php

namespace Fantismic\AlertSystem\Traits\Alerts\Channels;

use Fantismic\AlertSystem\Services\TelegramService;
use Illuminate\Support\Facades\Log;
use Fantismic\AlertSystem\Facades\Alert;
use Fantismic\AlertSystem\Models\AlertRecipient;

trait TelegramNotification
{
    public function telegramAlert($recipient, $type, $message, $details = [], $subject = null) {
        $telegram = app(TelegramService::class);

        $text = "<b>" . ($subject) . "</b>\n" . $message . "\n\n";

        foreach ($details as $k => $v) {
            $text .= "<b>{$k}:</b> {$v}\n";
        }

        $botKey = $recipient->bot ?? 'default';
        $telegram->sendMessage($recipient->address, $text, $botKey);
    }
}

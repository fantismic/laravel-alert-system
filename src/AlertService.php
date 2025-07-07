<?php

namespace Fantismic\AlertSystem;

use Fantismic\AlertSystem\Models\AlertRecipient;
use Fantismic\AlertSystem\Notifications\ErrorAlertNotification;
use Illuminate\Support\Facades\Notification;

class AlertService
{
    public function send(string $type, string $message, array $details = [])
    {
        $recipients = AlertRecipient::with('type', 'channel')
            ->whereHas('type', fn($q) => $q->where('name', $type))
            ->get();

        foreach ($recipients as $recipient) {
            Notification::route($recipient->channel->name, $recipient->address)
                ->notify(new ErrorAlertNotification($type, $message, $details));
        }
    }
}
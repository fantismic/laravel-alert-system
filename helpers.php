<?php

use VendorName\AlertSystem\Models\AlertRecipient;
use VendorName\AlertSystem\Notifications\ErrorAlertNotification;
use Illuminate\Support\Facades\Notification;

if (!function_exists('sendErrorAlert')) {
    function sendErrorAlert(string $type, string $message, array $details = []) {
        $recipients = AlertRecipient::with('type', 'channel')
            ->whereHas('type', fn($q) => $q->where('name', $type))
            ->get();

        foreach ($recipients as $recipient) {
            $notifiable = new class($recipient->address, $recipient->channel->name) {
                use Illuminate\Notifications\Notifiable;
                public function __construct(public string $address, public string $channel) {}
                public function routeNotificationForMail()    { return $this->channel === 'mail' ? $this->address : null; }
                public function routeNotificationForTelegram(){ return $this->channel === 'telegram' ? $this->address : null; }
            };

            Notification::route($recipient->channel->name, $recipient->address)
                ->notify(new ErrorAlertNotification($type, $message, $details));
        }
    }
}

<?php

namespace Fantismic\AlertSystem;

use Fantismic\AlertSystem\Models\AlertRecipient;
use Fantismic\AlertSystem\Notifications\ErrorAlertNotification;
use Illuminate\Notifications\Notifiable;

class AlertService
{
    public function send(string $type, string $message, array $details = [], string $subject = null)
    {

        if (!in_array(app()->environment(), config('alert-system.envs', []))) {
            return;
        }

        $recipients = AlertRecipient::with('type', 'channel')
            ->whereHas('type', fn($q) => $q->where('name', $type))
            ->get();



        foreach ($recipients as $recipient) {
            $notifiable = new class($recipient->address, $recipient->channel->name) {
                use Notifiable;

                public function __construct(public string $address, public string $channel) {}

                public function routeNotificationForTelegram()
                {
                    return $this->channel === 'telegram' ? $this->address : null;
                }

                public function routeNotificationForMail()
                {
                    return $this->channel === 'mail' ? $this->address : null;
                }
            };

            $notifiable->notify(
                new ErrorAlertNotification($type, $message, $details, $recipient->channel->name, $subject)
            );
        }
    }
}

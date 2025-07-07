<?php

namespace Fantismic\AlertSystem;

use Illuminate\Notifications\Notifiable;
use Fantismic\AlertSystem\Models\AlertLog;
use Fantismic\AlertSystem\Models\AlertRecipient;
use Fantismic\AlertSystem\Notifications\ErrorAlertNotification;

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
            $logRecipients[] = [
                'channel' => $recipient->channel->name,
                'address' => $recipient->address,
            ];

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

            try {
                $notifiable->notify(
                    new ErrorAlertNotification($type, $message, $details, $recipient->channel->name, $subject)
                );

                if (config('alert-system.logging.enabled')) {
                    logger()
                        ->channel(config('alert-system.logging.channel', 'stack'))
                        ->{config('alert-system.logging.level', 'info')}("[AlertSystem] Alert successfully sent", [
                            'type' => $type,
                            'channel' => $recipient->channel->name,
                            'address' => $recipient->address,
                            'subject' => $subject ?? "{$type} Alert",
                            'message' => $message,
                            'details' => $details,
                            'recipients' => $logRecipients,
                        ]);
                }
                if(config('alert-system.db-history', false)) {
                    AlertLog::create([
                        'type' => $type,
                        'channel' => $recipient->channel->name,
                        'address' => $recipient->address,
                        'status' => 'success',
                        'subject' => $subject ?? "{$type} Alert",
                        'message' => $message,
                        'details' => $details,
                        'sent_at' => now(),
                    ]);
                }

            } catch (\Throwable $e) {
                logger()
                    ->channel(config('alert-system.logging.channel', 'stack'))
                    ->error("[AlertSystem] Failed to send alert", [
                            'type' => $type,
                            'channel' => $recipient->channel->name,
                            'address' => $recipient->address,
                            'subject' => $subject ?? "{$type} Alert",
                            'message' => $message,
                            'details' => $details,
                            'recipients' => $logRecipients,
                        'error' => $e->getMessage(),
                    ]);
                
                if(config('alert-system.db-history', false)) {
                    AlertLog::create([
                        'type' => $type,
                        'channel' => $recipient->channel->name,
                        'address' => $recipient->address,
                        'status' => 'failure',
                        'subject' => $subject ?? "{$type} Alert",
                        'message' => $message,
                        'details' => $details,
                        'error_message' => $e->getMessage(),
                        'sent_at' => now(),
                    ]);
                }
            }
        }

    }
}

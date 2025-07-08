<?php

namespace Fantismic\AlertSystem;

use Fantismic\AlertSystem\Models\AlertLog;
use Fantismic\AlertSystem\Models\AlertRecipient;
use Fantismic\AlertSystem\Mail\ErrorAlertMail;
use Fantismic\AlertSystem\Services\TelegramService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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

        $logRecipients = [];
        $telegram = app(TelegramService::class);

        foreach ($recipients as $recipient) {
            $logRecipients[] = [
                'channel' => $recipient->channel->name,
                'address' => $recipient->address,
            ];

            $status = 'success';
            $error = null;

            try {
                if ($recipient->channel->name === 'mail') {
                    Mail::to($recipient->address)->send(new ErrorAlertMail($type, $message, $details, $subject));
                } elseif ($recipient->channel->name === 'telegram') {
                    $text = "<b>" . ($subject ?? "{$type} Alert") . "</b>\n" . $message . "\n\n";

                    foreach ($details as $k => $v) {
                        $text .= "<b>{$k}:</b> {$v}\n";
                    }

                    $telegram->sendMessage($recipient->address, $text);
                }

                if (config('alert-system.logging.enabled')) {
                    Log::channel(config('alert-system.logging.channel', 'stack'))
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

                if (config('alert-system.db-history', false)) {
                    AlertLog::create([
                        'type' => $type,
                        'channel' => $recipient->channel->name,
                        'address' => $recipient->address,
                        'status' => $status,
                        'subject' => $subject ?? "{$type} Alert",
                        'message' => $message,
                        'details' => $details,
                        'sent_at' => now(),
                    ]);
                }
            } catch (\Throwable $e) {
                $status = 'failure';
                $error = $e->getMessage();

                Log::channel(config('alert-system.logging.channel', 'stack'))->error("[AlertSystem] Failed to send alert", [
                    'type' => $type,
                    'channel' => $recipient->channel->name,
                    'address' => $recipient->address,
                    'subject' => $subject ?? "{$type} Alert",
                    'message' => $message,
                    'details' => $details,
                    'recipients' => $logRecipients,
                    'error' => $error,
                ]);

                if (config('alert-system.db-history', false)) {
                    AlertLog::create([
                        'type' => $type,
                        'channel' => $recipient->channel->name,
                        'address' => $recipient->address,
                        'status' => $status,
                        'subject' => $subject ?? "{$type} Alert",
                        'message' => $message,
                        'details' => $details,
                        'error_message' => $error,
                        'sent_at' => now(),
                    ]);
                }
            }
        }
    }

}

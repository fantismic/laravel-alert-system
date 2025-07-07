<?php

namespace Fantismic\AlertSystem\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramMessage;

class ErrorAlertNotification extends Notification
{
    public function __construct(
        public string $type,
        public string $message,
        public array $details = [],
        public string $channel = 'mail'
    ) {}

    public function via($notifiable)
    {
        return [$this->channel];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("{$this->type} Error Alert")
            ->line($this->message)
            ->line(json_encode($this->details));
    }

    public function toTelegram($notifiable)
    {
        if (!class_exists(\NotificationChannels\Telegram\TelegramMessage::class)) {
            return;
        }

        $chatId = $notifiable->routeNotificationForTelegram();

        if (!$chatId) {
            return;
        }

        return \NotificationChannels\Telegram\TelegramMessage::create()
            ->to($chatId)
            ->content(
                "<b>{$this->type} Error Alert:</b>\n" .
                "<i>{$this->message}</i>\n" .
                "<pre>" . htmlentities(json_encode($this->details, JSON_PRETTY_PRINT)) . "</pre>"
            )
            ->options(['parse_mode' => 'HTML']);
    }




}

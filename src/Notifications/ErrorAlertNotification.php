<?php

namespace VendorName\AlertSystem\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramMessage;

class ErrorAlertNotification extends Notification
{
    public function __construct(
        public string $type,
        public string $message,
        public array $details = []
    ) {}

    public function via($notifiable)
    {
        return ['mail', 'telegram'];
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
        return TelegramMessage::create()
            ->to($notifiable->routeNotificationForTelegram())
            ->content("*{$this->type} Error Alert:*
{$this->message}\n" . json_encode($this->details, JSON_PRETTY_PRINT));
    }
}

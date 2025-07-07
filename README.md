
# Laravel Alert System

A reusable Laravel package to send alerts via multiple channels (e.g., mail, telegram) based on alert **type** and **channel** combinations — stored in the database for easy admin management.

## ✨ Features

- Alert types like `System`, `GRC`, `User` (customizable)
- Channel support: `mail`, `telegram` (extensible)
- Dynamically manage recipients from the database
- Supports Laravel Notifications and queues
- Uses a Facade: `Alert::send(...)`

## 📦 Installation

```bash
composer require fantismic/alert-system
```

Publish migrations

```bash
php artisan vendor:publish --tag=alert-system-migrations
```

Run migrations:
```bash
php artisan migrate
```

If you want to publish the default config:

```bash
php artisan vendor:publish --tag=alert-system-config
```





If you want to publish seeders (for initial types/channels):

```bash
php artisan vendor:publish --tag=alert-system-seeders
php artisan db:seed --class=AlertTypesTableSeeder
php artisan db:seed --class=AlertChannelsTableSeeder
```

## 📁 Tables

This package creates and manages the following tables:

- `alert_types`
- `alert_channels`
- `alert_recipients`

Example:

| Type    | Channel  | Address               |
|---------|----------|------------------------|
| System  | mail     | admin@example.com     |
| System  | telegram | @sysadmin_channel     |
| User    | telegram | @support_channel      |

## 🚀 Usage

Anywhere in your app, send an alert using the Facade:

```php
use Fantismic\AlertSystem\Facades\Alert;

Alert::send('System', 'Something went wrong', [
    'error_code' => 500,
    'details' => 'Database not reachable',
    'subject' => 'Database gonna explode!'
]);
```

This will:
- Look up all recipients matching `type = System`
- For each channel (`mail`, `telegram`), send a notification

## 🧠 Signature

```php
Alert::send(
    string $type,
    string $message,
    array $details = [],
    string $subject = null
): void

## 🛠️ Customization

### Define More Types or Channels

You can insert new values in `alert_types` or `alert_channels`, or seed them via admin UI.

### Add More Recipients

Insert into `alert_recipients` with the corresponding `alert_type_id`, `alert_channel_id`, and `address`.

## 📬 Supported Channels

- Mail: via Laravel `MailMessage`
- Telegram: via [laravel-notification-channels/telegram](https://github.com/laravel-notification-channels/telegram)

> You must install and configure Telegram notifications if using Telegram:

```bash
composer require laravel-notification-channels/telegram
```

When using telegram add to config/services.php

```php
'telegram-bot-api' => [
    'token' => env('TELEGRAM_BOT_TOKEN')
],
```

And set in your .env
```yml
TELEGRAM_BOT_TOKEN=YOUR_BOT_TOKEN_HERE
```


---

## 🛠 Customizing Email Templates

You can fully customize the content of email alerts using Blade views. This supports both a **default view** and **per-alert-type views**.

### 📁 View Structure

After publishing the views:

```bash
php artisan vendor:publish --tag=alert-system-views
```

You’ll find:

```plaintext
resources/views/vendor/alert-system/mail/error_alerts/default.blade.php
```

---

### 🧱 Option 1: Basic Blade Template

Use this layout for a simple HTML email:

```blade
<h1>{{ $type }} Alert</h1>
<p>{{ $alertMessage }}</p>

@if (!empty($details))
<ul>
    @foreach($details as $key => $value)
        <li><strong>{{ $key }}:</strong> {{ $value }}</li>
    @endforeach
</ul>
@endif
```

The `alertMessage` and `details` variables are passed into the view from your notification.

---

### 🔁 Fallback Behavior

The package tries to load:

1. `alert-system::mail.error_alerts.{type}` (e.g. `system`, `grc`)
2. Falls back to: `alert-system::mail.error_alerts.default`

Use lowercase and replace spaces with underscores for type names.

---

## ✅ License

MIT © Fantismic

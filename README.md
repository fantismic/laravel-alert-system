# Laravel Alert System

A reusable Laravel package to send alerts via multiple channels (e.g., mail, telegram) based on alert **type** and **channel** combinations — stored in the database for easy admin management.

## ✨ Features

- Alert types like `System`, `GRC`, `User` (customizable)
- Channel support: `mail`, `telegram` (extensible)
- Dynamically manage recipients from the database
- Supports Laravel Notifications and queues
- Uses a Facade: `Alert::send(...)`
- Includes an optional dashboard with filters and search
- Logs each alert sent per recipient and status

### ✅ Requirements

#### Mandatory
- [x] Laravel >= 11
- [x] PHP >= 8.1
- [x] Database migrations

#### Optional
- [x] [laravel-notification-channels/telegram](https://github.com/laravel-notification-channels/telegram)
- [x] Tailwind CSS (for UI)
- [x] Livewire (for UI)

## 📦 Installation

```bash
composer require fantismic/alert-system
```

Publish migrations

```bash
php artisan vendor:publish --tag=alert-system-migrations
php artisan migrate
```

Publish configuration:

```bash
php artisan vendor:publish --tag=alert-system-config
```

> You can define:
> - Which **Blade layout** to use for the Livewire UI
> - Which **environments** (`envs`) are allowed to send alerts

Publish seeders (optional):

```bash
php artisan vendor:publish --tag=alert-system-seeders
php artisan db:seed --class=AlertTypesTableSeeder
php artisan db:seed --class=AlertChannelsTableSeeder
```

## 📁 Tables

This package creates the following tables:

- `alert_types`
- `alert_channels`
- `alert_recipients`
- `alert_logs`

Example:

| Type    | Channel  | Address            |
|---------|----------|--------------------|
| System  | mail     | admin@example.com  |
| System  | telegram | @sysadmin_channel  |

## 🚀 Usage

```php
use Fantismic\AlertSystem\Facades\Alert;

Alert::send('System', 'The disk is almost full', 
    [
        'host' => 'web-01',
        'threshold' => '95%',
    ], 
    subject: '🚨 Disk Alert: web-01');
```

This will:
- Look up all recipients for the given type
- Send via all associated channels (mail, telegram)
- Log success/failure per recipient

## 🧠 Signature

```php
Alert::send(
    string $type,
    string $message,
    array $details = [],
    string $subject = null
): void
```

## 🛠️ Customization

### Email Templates

After publishing the views:

```bash
php artisan vendor:publish --tag=alert-system-views
```

You'll find the default template at:

```
resources/views/vendor/alert-system/mail/error_alerts/default.blade.php
```

Use Blade logic to customize per type (e.g., `error_alerts.system.blade.php`).

### Telegram

```bash
composer require laravel-notification-channels/telegram
```

In `config/services.php`:

```php
'telegram-bot-api' => [
    'token' => env('TELEGRAM_BOT_TOKEN')
],
```

Then in `.env`:

```
TELEGRAM_BOT_TOKEN=your-token-here
```

## 🖥️ Admin UI

### 📍 Routes

| Path                      | Route Name         |
|---------------------------|--------------------|
| /admin/alerts/dashboard   | alerts.dashboard   |
| /admin/alerts/types       | alerts.types       |
| /admin/alerts/channels    | alerts.channels    |
| /admin/alerts/recipients  | alerts.recipients  |

Uses `web` and `auth` middleware by default.

### 💡 Features

- Create, edit, delete alert types, channels, and recipients
- View alert logs in a searchable, filterable table
- Filter by status (success/failure), type, channel
- View alert detail in a modal
- Export alert logs to CSV
- Dark mode support

## 📊 Logs

Each time an alert is sent, a log is created in the `alert_logs` table.

### 🧾 Columns

| Column         | Description                      |
|----------------|----------------------------------|
| id             | Primary key                      |
| type           | Alert type name                  |
| channel        | Channel name (mail/telegram)     |
| address        | Recipient address                |
| subject        | Subject used                     |
| message        | Message used                     |
| details        | JSON-encoded extra details       |
| status         | `success` or `failure`           |
| error_message  | Error if status is `failure`     |
| sent_at        | Timestamp                        |
| created_at     | Timestamp                        |
| updated_at     | Timestamp                        |

### 🧱 Model

You can use the model directly for custom dashboards:

```php
use Fantismic\AlertSystem\Models\AlertLog;

$recent = AlertLog::latest()->take(10)->get();
```

## ✅ License

MIT © Fantismic
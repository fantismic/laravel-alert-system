<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $type }} Alert</title>
    <style>
        :root {
            --bg: #ffffff;
            --text: #111827;
            --card-bg: #ffffff;
            --border: #e5e7eb;
            --accent: #3b82f6;
            --details-bg: #f3f4f6;
            --footer: #6b7280;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #1f2937;
                --text: #f3f4f6;
                --card-bg: #374151;
                --border: #4b5563;
                --accent: #60a5fa;
                --details-bg: #4b5563;
                --footer: #9ca3af;
            }
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 24px;
            margin: 0 auto;
        }
        .header {
            border-bottom: 2px solid var(--accent);
            padding-bottom: 8px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 20px;
            margin: 0;
            color: var(--text);
        }
        .message {
            font-size: 16px;
            margin-bottom: 20px;
            color: var(--text);
        }
        .details {
            background: var(--details-bg);
            border-radius: 6px;
            padding: 16px;
            font-family: monospace;
            font-size: 14px;
            white-space: pre-wrap;
            word-break: break-word;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: var(--footer);
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $type }} Alert</h1>
        </div>

        <div class="message">
            {!! nl2br(e($alertMessage)) !!}
        </div>

        @if (!empty($details))
            <div class="details">
{{ json_encode($details, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}
            </div>
        @endif

        <div class="footer">
            Sent automatically by the Fantismic Alert System
        </div>
    </div>
</body>
</html>
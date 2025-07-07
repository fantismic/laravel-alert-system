<?php

if (!function_exists('sendErrorAlert')) {
    function sendErrorAlert(string $type, string $message, array $details = []) {
        app()->booted(function () use ($type, $message, $details) {
            app('alert-system')->send($type, $message, $details);
        });
    }
}
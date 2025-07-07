<?php

namespace Fantismic\AlertSystem;

use Illuminate\Support\ServiceProvider;

class AlertSystemServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->booted(function () {
            }
        });

        $this->publishes([
            __DIR__.'/../config/alert-system.php' => config_path('alert-system.php'),
        ], 'alert-system-config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/seeders' => database_path('seeders'),
            ], 'alert-system-seeders');
        }

        }
    
    public function register(): void
    {
        $this->app->singleton('alert-system', function ($app) {
            return new class {
                public function send(string $type, string $message, array $details = []) {
                    sendErrorAlert($type, $message, $details);
                }
            };
        });
    }

}

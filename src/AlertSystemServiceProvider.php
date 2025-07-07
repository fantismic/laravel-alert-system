<?php

namespace Fantismic\AlertSystem;

use Illuminate\Support\ServiceProvider;

class AlertSystemServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // ✅ ADD THIS BLOCK:
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'alert-system-migrations');

        $this->publishes([
            __DIR__.'/../config/alert-system.php' => config_path('alert-system.php'),
        ], 'alert-system-config');

        $this->publishes([
            __DIR__.'/../database/seeders' => database_path('seeders'),
        ], 'alert-system-seeders');
    }
    
    public function register(): void
    {
        $this->app->singleton('alert-system', function ($app) {
            return new AlertService();
        });
    }

}

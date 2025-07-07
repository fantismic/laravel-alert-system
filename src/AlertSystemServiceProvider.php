<?php

namespace Fantismic\AlertSystem;

use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;
use Fantismic\AlertSystem\Http\Livewire\ManageLogs;
use Fantismic\AlertSystem\Http\Livewire\ManageTypes;
use Fantismic\AlertSystem\Http\Livewire\ManageChannels;
use Fantismic\AlertSystem\Http\Livewire\ManageRecipients;

class AlertSystemServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'alert-system');
        $this->loadRoutesFrom(__DIR__ . '/../routes/alert-system.php');

        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/alert-system'),
        ], 'alert-system-views');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'alert-system-migrations');

        $this->publishes([
            __DIR__.'/../config/alert-system.php' => config_path('alert-system.php'),
        ], 'alert-system-config');

        $this->publishes([
            __DIR__.'/../database/seeders' => database_path('seeders'),
        ], 'alert-system-seeders');

        Livewire::component('alert-system.manage-types', ManageTypes::class);
        Livewire::component('alert-system.manage-recipients', ManageRecipients::class);
        Livewire::component('alert-system.manage-channels', ManageChannels::class);
        Livewire::component('alert-system.manage-logs', ManageLogs::class);
    }
    
    public function register(): void
    {
        $this->app->singleton('alert-system', function ($app) {
            return new AlertService();
        });
    }

}

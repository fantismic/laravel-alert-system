<?php

use Illuminate\Support\Facades\Route;
use Fantismic\AlertSystem\Http\Livewire\ManageLogs;
use Fantismic\AlertSystem\Http\Livewire\ManageTypes;
use Fantismic\AlertSystem\Http\Livewire\ManageChannels;
use Fantismic\AlertSystem\Http\Livewire\ManageRecipients;

Route::middleware(['web', 'auth'])->prefix('admin/alerts')->group(function () {
    Route::get('/recipients', ManageRecipients::class)->name('alerts.recipients');
    Route::get('/types', ManageTypes::class)->name('alerts.types');
    Route::get('/channels', ManageChannels::class)->name('alerts.channels');
    Route::get('/dashboard', ManageLogs::class)->name('alerts.dashboard');
});

<?php

use Illuminate\Support\Facades\Route;
use Fantismic\AlertSystem\Http\Livewire\ManageRecipients;
use Fantismic\AlertSystem\Http\Livewire\ManageTypes;
use Fantismic\AlertSystem\Http\Livewire\ManageChannels;

Route::middleware(['web', 'auth'])->prefix('admin/alerts')->group(function () {
    Route::get('/recipients', ManageRecipients::class)->name('alerts.recipients');
    Route::get('/types', ManageTypes::class)->name('alerts.types');
    Route::get('/channels', ManageChannels::class)->name('alerts.channels');
});

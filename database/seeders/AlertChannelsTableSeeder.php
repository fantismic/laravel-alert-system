<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Fantismic\AlertSystem\Models\AlertChannel;

class AlertChannelsTableSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['mail', 'telegram'] as $channel) {
            AlertChannel::firstOrCreate(['name' => $channel]);
        }
    }
}

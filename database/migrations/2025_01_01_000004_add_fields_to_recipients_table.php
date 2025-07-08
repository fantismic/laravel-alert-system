<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('alert_recipients', function (Blueprint $table) {
            $table->string('bot')->nullable()->after('address');
            $table->boolean('is_active')->default(true)->after('alert_channel_id');
        });
    }

    public function down(): void {
        Schema::dropIfExists('alert_recipients');
    }
};

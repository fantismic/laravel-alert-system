<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('alert_logs', function (Blueprint $table) {
            $table->string('bot')->nullable()->after('address');
        });
    }

    public function down(): void {
        Schema::dropIfExists('alert_logs');
    }
};

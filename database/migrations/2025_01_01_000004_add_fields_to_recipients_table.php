<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('alert_recipients', function (Blueprint $table) {
            $table->id();
            $table->string('bot')->nullable()->after('address');;
            $table->boolean('is_active')->default(true)->after('bot');;
        });
    }

    public function down(): void {
        Schema::dropIfExists('alert_recipients');
    }
};

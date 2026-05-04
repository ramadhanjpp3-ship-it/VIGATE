<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('vehicles') && ! Schema::hasColumn('vehicles', 'ktm_photo')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->string('ktm_photo')->nullable()->after('vehicle_photo');
            });
        }

        if (Schema::hasTable('access_logs') && ! Schema::hasColumn('access_logs', 'gate_device_id')) {
            Schema::table('access_logs', function (Blueprint $table) {
                $table->foreignId('gate_device_id')->nullable()->after('nfc_uid')
                      ->constrained('gate_devices')
                      ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('vehicles') && Schema::hasColumn('vehicles', 'ktm_photo')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->dropColumn('ktm_photo');
            });
        }

        if (Schema::hasTable('access_logs') && Schema::hasColumn('access_logs', 'gate_device_id')) {
            Schema::table('access_logs', function (Blueprint $table) {
                $table->dropConstrainedForeignId('gate_device_id');
            });
        }
    }
};

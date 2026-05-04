<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('stnk_photo')->nullable()->after('stnk_number');
            $table->string('vehicle_photo')->nullable()->after('stnk_photo');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['stnk_photo', 'vehicle_photo']);
        });
    }
};

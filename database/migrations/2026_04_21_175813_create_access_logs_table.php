<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('access_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            $table->string('nfc_uid');
            $table->string('plate_number')->nullable();

            $table->string('face_image')->nullable();
            $table->string('vehicle_image')->nullable();

            $table->enum('status', ['allowed','denied']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_logs');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logistics', function (Blueprint $table) {
            $table->id();
            $table->string('log_id')->unique()->index();
            $table->string('from');
            $table->string('to');
            $table->string('vehicle_type');
            $table->string('weight');
            $table->string('request_by');
            $table->string('price')->nullable();
            $table->string('diver_name')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('car_no')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logistics');
    }
};

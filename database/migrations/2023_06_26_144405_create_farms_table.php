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
        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->uuid('farm_id')->index();
            $table->string('farmer_id');
            $table->string('farm_name');
            $table->json('gallery')->nullable();
            $table->string('farm_reg_no')->nullable();
            $table->string('address');
            $table->string('union');
            $table->string('mouaza');
            $table->decimal('lat',10,8)->nullable();
            $table->decimal('long',10,8)->nullable();
            $table->string('farm_area');
            $table->string('soil_type');
            $table->string('current_crop');
            $table->dateTime('starting_date');
            $table->boolean('isActive')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farms');
    }
};

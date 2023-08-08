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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('farmer_id');
            $table->string('me_id');
            $table->string('cp_id');

            $table->json('current_seed')->nullable();
            $table->json('current_fertilizer')->nullable();
            $table->json('current_pesticide')->nullable();

            $table->json('future_seed')->nullable();
            $table->json('future_fertilizer')->nullable();
            $table->json('future_pesticide')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};

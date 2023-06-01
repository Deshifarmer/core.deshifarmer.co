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
        Schema::create('crop_batch', function (Blueprint $table) {
            $table->id();
            $table->string('ceop_batch_id');
            $table->string('farmer_id');
            $table->string('farm_id');
            $table->string('crop_id'); //product id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_batch');
    }
};

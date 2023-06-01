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
        Schema::create('crop_staging', function (Blueprint $table) {
            $table->id();
            $table->string('activity_id');//activity id or type
            $table->string('recored_by');
            $table->bigInteger('record_farm_id');//farm id
            $table->string('record_details');
            $table->json('record_images');
            $table->string('crop_batch_id');//batch id
            $table->decimal('harvest_quantity')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_staging');
    }
};

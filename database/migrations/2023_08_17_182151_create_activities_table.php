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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('farmer_id');
            $table->string('farm');
            $table->string('crop');
            // $table->string('type');
            $table->string('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->json('location');
            $table->string('activity_by');
            $table->string('details');
            $table->json('images');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};

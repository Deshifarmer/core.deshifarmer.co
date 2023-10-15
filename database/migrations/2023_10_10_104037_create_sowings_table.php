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
        Schema::create('sowings', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id');
            $table->string('seed_name')->nullable();
            $table->string('seed_company')->nullable();
            $table->string('seed_price')->nullable();
            $table->string('seed_quantity')->nullable();
            $table->string('seed_unit')->nullable();
            $table->string('details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sowings');
    }
};

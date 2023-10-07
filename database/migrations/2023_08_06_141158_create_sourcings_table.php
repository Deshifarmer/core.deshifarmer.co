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
        Schema::create('sourcings', function (Blueprint $table) {
            $table->id();
            $table->string('which_farmer');
            $table->uuid('source_id')->unique()->index();
            $table->string('batch_id')->nullable();
            $table->string('product_name');
            $table->string('product_images')->nullable();
            $table->string('variety')->nullable();
            $table->double('buy_price',8,2)->nullable();
            $table->double('sell_price',8,2)->nullable();
            $table->bigInteger('quantity');
            $table->string('unit');
            $table->string('description')->nullable();
            $table->string('source_by'); //me id
            $table->string('source_location')->nullable();
            $table->boolean('is_sorted')->default();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sourcings');
    }
};

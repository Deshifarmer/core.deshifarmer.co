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
            $table->uuid('source_id')->unique()->index();
            $table->string('product_name');
            $table->string('product_images');
            $table->string('buy_price')->nullable();
            $table->string('sell_price')->nullable();
            $table->string('quantity');
            $table->string('unit');
            $table->string('description')->nullable();
            $table->string('category');
            $table->string('which_farmer');
            $table->string('source_by'); //me id
            $table->string('transportation_id')->nullable();
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

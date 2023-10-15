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
        Schema::create('source_sellings', function (Blueprint $table) {
            $table->id();
            $table->string('source_id');
            $table->string('customer_id')->nullable();
            $table->string('sell_location');
            $table->decimal('sell_price',8,2);
            $table->integer('quantity');
            $table->string('sold_by');
            $table->string('market_type')->nullable();
            $table->string('payment_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('source_sellings');
    }
};

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
        Schema::create('input_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->index();
            $table->string('me_id');
            $table->string('channel_id');
            $table->decimal('total_price');
            $table->string('sold_to'); //farmer_id
            $table->string('status')->default('pending'); //pending, approved, rejected, delivered, cancelled
            $table->string('payment_method')->default('pending');
            $table->string('payment_id')->default('pending');
            $table->string('delivery_status')->default('pending');
            $table->decimal('hq_commission')->nullable();
            $table->decimal('me_commission')->nullable();
            $table->decimal('distributor_commission')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_orders');
    }
};

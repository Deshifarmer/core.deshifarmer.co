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
        Schema::create('input_order_me', function (Blueprint $table) {
            $table->id();
            $table->string('marchent_id');//employee id
            $table->string('selling_product');
            $table->decimal('selling_quantity');
            $table->decimal('selling_total_price');
            $table->string('sold_to');//customer id
            $table->dateTime('selling_time');
            $table->string('payment_status')->default('pending');
            $table->string('payment_id')->nullable();//payment id
            $table->string('delivery_status')->default('pending');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_order_me');
    }
};

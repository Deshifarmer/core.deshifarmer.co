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
        Schema::create('inputs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku');
            $table->string('image');
            $table->bigInteger('category');
            $table->bigInteger('company');
            $table->bigInteger('stock');
            $table->decimal('purchase_price');
            $table->decimal('expence');
            $table->decimal('selling_price');
            $table->decimal('discount');
            $table->decimal('cp_commission');
            $table->decimal('me_commission');
            $table->decimal('hq_commission');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inputs');
    }
};

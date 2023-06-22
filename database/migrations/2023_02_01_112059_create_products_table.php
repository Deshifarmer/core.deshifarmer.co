<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('product_id')->index();
            $table->string('name');
            $table->string('image');
            $table->string('description')->nullable();
            $table->string('preferred')->nullable();
            $table->bigInteger('category_id');
            $table->bigInteger('subcategory_id')->nullable();
            $table->string('company_id');
            $table->string('unit');
            $table->decimal('buy_price_from_company');//hq buying price from company
            $table->decimal('sell_price_from_company');//Hq selling price set by company
            $table->decimal('sell_price'); // sell_price_from_company == sell_price (it could be modified by HQ)
            $table->decimal('discount')->nullable();
            $table->decimal('hq_commission')->nullable();
            $table->decimal('me_commission')->nullable();
            $table->decimal('distributor_commission')->nullable();
            $table->string('status')->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

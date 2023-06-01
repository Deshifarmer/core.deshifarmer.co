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
        Schema::create('market_prices', function (Blueprint $table) {
            $table->id();
            $table->dateTime('entry_date');
            $table->string('product_name') ;
            $table->float('unit_price');
            $table->string('entry_by')->nullable() ;
            $table->string('which_market') ;
            $table->string('union') ;
            $table->string('upazila') ;
            $table->string('district') ;
            $table->string('price_from') ;
            $table->string('data_from_type') ;
            $table->string('contact_no')->nullable();
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
        Schema::dropIfExists('market_prices');
    }
};

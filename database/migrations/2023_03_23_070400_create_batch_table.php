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
        Schema::create('batches', function (Blueprint $table) {
            $table->string('batch_id') ;
            $table->string('sourcing_address')  ;
            $table->string('sourcing_quantity')  ;
            $table->float('sourcing_price');
            $table->string('sourced_by')  ;//employee_id
            $table->string('sourced_from_id')  ;//farmer_id
            $table->string('sourced_product');//product_id
            $table->float('sourcing_cost');
            $table->float('total_cost');
            // $table->dateTimeTz('sourcing_date');
            $table->string('going_to')  ;//workplace_id
            $table->string('batch_status')  ;
            $table->dateTimeTz('sending_time');
            $table->string('batch_driver_name')  ;
            $table->string('batch_driver_phone');
            $table->string('vehicle_license_number');
            $table->string('vehicle_capacity')  ;
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
        Schema::dropIfExists('batch');
    }
};

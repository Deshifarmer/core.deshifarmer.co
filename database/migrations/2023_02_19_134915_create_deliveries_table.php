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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('delivery_batch_id'); //confusued about type because its my be auto incremented field
            $table->string('delivery_man');      //employee_id
            $table->string('delivery_product'); //sales_order_id
            $table->dateTime('delivery_time');
            $table->string('delivery_address');
            $table->float('delivery_latitude');
            $table->float('delivery_longitude');
            $table->string('delivery_status');
            $table->string('delivery_payment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
};

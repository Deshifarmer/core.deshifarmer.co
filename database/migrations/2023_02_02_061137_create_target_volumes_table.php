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
        Schema::create('target_volumes', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id') ->unigned();//employee_id
            $table->string('target_product_sub_category')  ;//subcat_id
            $table->integer('target_volume');
            $table->dateTimeTz('date');
            $table->integer('achieved');
            $table->float('comission');
            $table->dateTimeTz('target_time');

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
        Schema::dropIfExists('target_volumes');
    }
};

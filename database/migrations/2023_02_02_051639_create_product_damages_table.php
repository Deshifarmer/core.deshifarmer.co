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
        Schema::create('product_damages', function (Blueprint $table) {
            $table->id();
            $table->string('graded_id')  ;//graded_stock_id
            $table->integer('damage_quantity');
            $table->dateTime('date');
            $table->string('entry_by')->length(195) ;//employee_id
            $table->string('work_place_id')  ;//workplace_id
            $table->string('remarks') ;
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
        Schema::dropIfExists('product_damages');
    }
};

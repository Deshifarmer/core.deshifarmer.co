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
        Schema::create('batch_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id');//batch id
            $table->string('transportation_type') ;
            $table->float('labor_cost');
            $table->float('transportation_cost');
            $table->float('other_cost');
            $table->string('remarks') ;
            // $table->dateTimeTz('date');
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
        Schema::dropIfExists('batch_expenses');
    }
};

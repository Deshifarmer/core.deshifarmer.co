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
        Schema::create('farmers_point_cost', function (Blueprint $table) {
            $table->id();
            $table->string('farmers_point')  ;//framer points id
            $table->float('cost_amount');
            $table->float('remaining_amount');
            $table->string('fund_distribution_id') ;
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
        Schema::dropIfExists('farmers_point_cost');
    }
};

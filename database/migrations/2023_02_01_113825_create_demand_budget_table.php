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
        Schema::create('demand_budgets', function (Blueprint $table) {
            $table->id();
            $table->string('demand_id');
            $table->string('fermers_point')  ;//farmares point id
            $table->float('disbursed_amount');
            $table->string('disbursed_by')  ;//employee_id
            $table->dateTimeTz('disbursed_time');
            $table->boolean('is_authorized');
            $table->string('authorized_by')  ;//employee_id
            $table->string('remarks') ;
            $table->dateTimeTz('demand_date');
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
        Schema::dropIfExists('demand_budger');
    }
};

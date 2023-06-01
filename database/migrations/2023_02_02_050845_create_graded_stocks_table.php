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
        Schema::create('graded_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id')  ;//batch_id
            $table->string('grade') ;
            $table->integer('quantity');
            $table->string('graded_by') ;//employee_id
            $table->integer('graded_id');
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
        Schema::dropIfExists('graded_stocks');
    }
};

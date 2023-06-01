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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('account_head') ;
            $table->string('account_type') ;
            $table->string('order') ;
            $table->string('entry_by')  ;//employee_id
            $table->dateTime('entry_time');
            $table->float('amount');
            $table->float('due');
            $table->string('payment_mode') ;
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
        Schema::dropIfExists('payments');
    }
};

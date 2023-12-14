<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('request_finances', function (Blueprint $table) {
            $table->id();
            $table->string('which_farmer');
            $table->string('season');
            $table->string('producing_crop');
            $table->string('variety')->nullable();
            $table->string('purpose_of_loan');
            $table->string('order_id')->nullable();
            $table->double('amount_of_loan');
            $table->string('which_fp')->nullable();
            $table->double('df_approved_loan')->default(0);
            $table->string('season_and_eta_sales')->nullable();
            $table->string('note')->nullable();
            $table->string('payment_schedule');
            $table->string('payment_dates');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_finances');
    }
};

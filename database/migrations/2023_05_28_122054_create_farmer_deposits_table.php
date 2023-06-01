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
        Schema::create('farmer_deposits', function (Blueprint $table) {
            $table->id();
            $table->string('deposit_id')->unique();
            $table->string('farmer_id');
            $table->decimal('amount');
            $table->string('deposit_method');
            $table->string('deposit_status')->default('accepeted by m.e.');
            $table->string('transaction_id')->nullable();
            $table->string('which_input_order_id');
            $table->string('rcv_by_me_id')->nullable();
            $table->string('rcv_by_dis_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmer_deposits');
    }
};

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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('df_id');
            $table->string('transaction_id')->index()->unique();
            $table->string('ammount');
            $table->string('order_id')->nullable();
            $table->string('method');
            $table->string('type');
            $table->string('credited_to');
            $table->string('debited_from');
            $table->string('authorized_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

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
        Schema::create('employee_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('acc_number')->index(); //emloyee df_id
            $table->decimal('net_balence',12,2)->default(0.00);
            $table->decimal('total_credit',12,2)->default(0.00);
            $table->decimal('total_debit',12,2)->default(0.00);
            $table->string('last_transaction')->nullable(); //transaction id
            $table->decimal('last_transaction_amount')->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_accounts');
    }
};

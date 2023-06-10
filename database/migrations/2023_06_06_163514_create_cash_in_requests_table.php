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
        Schema::create('cash_in_requests', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_id')->index()->unique();
            $table->string('df_id');
            $table->decimal('requested',12,2);
            $table->decimal('accepted_amount',12,2)->nullable();
            $table->string('receipt')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_in_requests');
    }
};

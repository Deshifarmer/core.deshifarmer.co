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
        Schema::create('output_customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('address')->nullable();
            $table->string('phone_number')->unique();
            $table->string('onboard_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('output_customers');
    }
};

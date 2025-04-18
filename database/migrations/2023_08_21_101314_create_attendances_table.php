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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('check_in');
            $table->string('check_out')->nullable();
            $table->json('cin_location');
            $table->json('cout_location')->nullable();
            $table->text('cin_note')->nullable();
            $table->text('cout_note')->nullable();
            $table->string('cin_image');
            $table->string('cout_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};

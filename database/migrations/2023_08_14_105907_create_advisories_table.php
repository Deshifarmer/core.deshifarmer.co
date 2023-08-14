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
        Schema::create('advisories', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('time_slot');
            $table->text('farmer_group_id');
            $table->json('files');
            $table->string('note');
            $table->string('created_by'); //me id
            $table->string('updated_by')->nullable();
            $table->string('advised_by')->nullable();
            $table->string('advised_at')->nullable();
            $table->string('advised_note')->nullable();
            $table->string('advised_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisories');
    }
};

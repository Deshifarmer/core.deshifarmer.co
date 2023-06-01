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
        Schema::create('farmers_group', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('address');
            $table->boolean('is_active')->default(true);
            $table->string('farmers_point_id');
            $table->string('group_manager_id');
            $table->string('group_president');
            $table->string('group_secretary');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmers_group');
    }
};

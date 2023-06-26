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
        Schema::create('farmer_groups', function (Blueprint $table) {
            $table->id();
            $table->uuid('farmer_group_id')->index();
            $table->string('farmer_group_name');
            $table->string('cluster_id');
            $table->boolean('isActive')->default(true);
            $table->dateTime('inactive_at')->nullable();
            $table->string('group_manager_id'); // me id
            $table->string('group_leader'); // Farmer id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmer_groups');
    }
};

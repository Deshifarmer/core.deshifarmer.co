<?php

use App\Models\v1\FarmerGroup;
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
        Schema::table('advisories', function (Blueprint $table) {
            $table->dropColumn('note');
            $table->text('farmer_group_id')->nullable()->change();
            $table->json('farmer_list');
            $table->json('files')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advisories', function (Blueprint $table) {
            $table->text('farmer_group_id')->nullable()->change();
            $table->json('farmer_list');
            $table->json('files')->nullable()->change();
        });
    }
};

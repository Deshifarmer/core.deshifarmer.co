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
        Schema::create('distributors_files', function (Blueprint $table) {
            $table->id();
            $table->string('df_id')->index();
            $table->string('business_present_address');
            $table->string('business_contact_no');
            $table->string('tin_no')->nullable();
            //documents
            $table->string('signature')->nullable();
            $table->string('bio_data')->nullable();
            $table->string('trade_license')->nullable();
            $table->string('agri_license')->nullable();
            $table->string('vat_certificate')->nullable();
            $table->string('bank_solvency')->nullable();
            $table->string('nid_front')->nullable();
            $table->string('nid_back')->nullable();
            $table->string('character_certificate')->nullable();
            $table->string('tax_report')->nullable();
            $table->string('owner_prove')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributors_files');
    }
};

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
        Schema::create('distributor_infos', function (Blueprint $table) {
            $table->id();
            $table->string('distributor_id')->index();
            $table->string('company_name');
            $table->string('business_type');
            $table->string('business_present_address');
            $table->string('business_contact_no');
            $table->boolean('is_known_to_deshi_farmer')->default(false);
            $table->string('interested_to_invest_ammount');
            $table->string('interested_to_earn_from_df');
            //personal information
            $table->string('applicent_name');
            $table->string('applicent_age');
            $table->string('gender');
            $table->string('nationality');
            $table->string('permanent_address');
            $table->string('present_address');
            $table->string('personal_contact_no');
            $table->string('nid_no')->unique();
            $table->string('tin_no')->nullable();
            //documents
            $table->string('signature')->nullable();
            $table->string('bio_data')->nullable();
            $table->string('trade_licence')->nullable();
            $table->string('agro_licence')->nullable();
            $table->string('vat_certificate')->nullable();
            $table->string('bank_solvency')->nullable();
            $table->string('nid')->nullable();
            $table->string('character_certificate')->nullable();
            $table->string('tax_report')->nullable();
            $table->string('owner_prove')->nullable();
            $table->string('foujdari_oporadh_sawgohon_potro')->nullable();
            $table->string('image')->nullable();
            //refference
            $table->string('refference')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributor_informations');
    }
};

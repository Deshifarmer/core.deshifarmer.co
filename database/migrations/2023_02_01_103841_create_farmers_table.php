<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farmers', function (Blueprint $table) {
            $table->id();
            $table->uuid('farmer_id')->index();
            $table->string('image')->nullable();
            $table->string('farmer_type');
            $table->string('onboard_by');
            $table->bigInteger('nid')->unique();
            $table->bigInteger('gov_farmer_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('fathers_name');
            $table->string('phone')->unique();
            $table->boolean("is_married");
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('address');
            $table->string('village');
            $table->string('union')->nullable();
            $table->integer('upazila');
            $table->integer('district');
            $table->integer('division');
            $table->decimal('credit_score')->nullable();
            $table->string('resident_type'); // own house rent house
            $table->integer('family_member');
            $table->integer('number_of_children');
            $table->decimal('yearly_income');
            $table->decimal('year_of_stay_in');
            $table->json('group_id')->nullable(); //array nullable
            // $table->bigInteger('farmer_role');
            $table->json("bank_details")->nullable();
            $table->json("mfs_account")->nullable();
            $table->json("current_producing_crop")->nullable();
            $table->json("focused_crop")->nullable();
            $table->json('farm_id')->nullable();
            $table->string('cropping_intensity')->default('single crop');
            $table->string('cultivation_practice')->default('traditional');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farmers');
    }
};

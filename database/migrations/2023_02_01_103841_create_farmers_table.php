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
            $table->string('input_by');
            $table->bigInteger('nid')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->unique();
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('address');
            $table->string('village');
            $table->integer('upazila');
            $table->integer('district');
            $table->integer('division');
            $table->decimal('credit_score')->nullable();
            $table->string('land_status');
            $table->integer('family_member');
            $table->integer('number_of_children');
            $table->decimal('yearly_income');
            $table->decimal('year_of_stay_in');
            $table->string('group_id')->nullable();
            $table->bigInteger('farmer_role');
            $table->bigInteger('farm_id')->nullable();
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

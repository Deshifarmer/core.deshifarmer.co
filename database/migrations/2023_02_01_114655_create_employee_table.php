<?php

use Illuminate\Database\Eloquent\Relations\HasMany;
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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('df_id')->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->bigInteger('nid')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->integer('type'); // 0 = HQ, 1 = CO, 2 = DB, 3 = ME
            $table->string('onboard_by');
            $table->string('photo')->default('/image/employee/default.png');
            $table->dateTimeTz('date_of_birth')->nullable();
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->integer('home_district')->nullable();
            $table->dateTimeTz('joining_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('channel')->nullable();
            $table->string('channel_assign_by')->nullable();
            $table->string('under')->nullable(); //me under which distributor
            $table->string('status')->default('active');
            $table->decimal('lat')->nullable();
            $table->decimal('long')->nullable();

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
        Schema::dropIfExists('employee');
    }
};

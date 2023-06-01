<?php

use App\Models\Employee;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        Schema::create('farmers_points', function (Blueprint $table) {
            $table->id();
            $table->string('farmers_point_id') ;
            $table->string('title') ;
            $table->string('address') ;
            $table->string('farmers_point_type') ;
            $table->string('current_manager');
            $table->string('mobile_number') ;
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
        Schema::dropIfExists('farmers_points');
    }

};

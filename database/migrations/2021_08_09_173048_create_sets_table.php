<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sets', function (Blueprint $table) {
            $table->id();
            $table->decimal("new_i")->nullable()->comment("新能源每公里积分");
            $table->decimal("new_e")->nullable()->comment("新能源每公里减排");
            $table->decimal("car_i")->nullable()->comment("燃油车每公里积分");
            $table->decimal("car_e")->nullable()->comment("燃油车每公里减排");
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
        Schema::dropIfExists('sets');
    }
}

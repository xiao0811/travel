<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewEnergiesyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_energies', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id")->comment("用户ID");
            $table->unsignedInteger("car_id")->nullable()->comment("车辆ID");
            $table->string("start_mileage")->nullable("开始里程");
            $table->string("end_mileage")->nullable("结束里程");
            $table->decimal("mileage")->nullable()->comment("里程");
            $table->unsignedTinyInteger("type")->nullable()->comment("类型");
            $table->unsignedTinyInteger("status")->nullable()->comment("状态");
            $table->string("remark")->nullable()->comment("备注");
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
        Schema::dropIfExists('_new_energiesy');
    }
}

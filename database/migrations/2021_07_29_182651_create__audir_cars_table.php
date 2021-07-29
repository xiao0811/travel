<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudirCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id")->comment("用户ID");
            $table->string("car_number")->nullable()->comment("车牌号");
            $table->string("car_pic")->nullable()->comment("车图片");
            $table->unsignedTinyInteger("type")->nullable()->comment("分类 1: 电动车, 2: 燃油车");
            $table->unsignedTinyInteger("status")->nullable()->comment("状态 1: 审核中, 10: 审核拒绝, 20: 审核撤销, 30: 审核通过");
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
        Schema::dropIfExists('_audir_cars');
    }
}

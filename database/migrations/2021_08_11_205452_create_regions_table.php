<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable()->comment("地区名");
            $table->text("content")->nullable()->comment("地区介绍");
            $table->unsignedTinyInteger("status")->nullable()->comment("1: 启用, 2: 关闭");
            $table->string("x_axis")->nullable()->comment("X坐标");
            $table->string("y_axis")->nullable()->comment("Y坐标");
            $table->unsignedTinyInteger("type")->nullable()->comment("类型(预留)");
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
        Schema::dropIfExists('regions');
    }
}

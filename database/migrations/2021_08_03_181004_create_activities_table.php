<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string("title")->nullable()->comment("活动标题");
            $table->string("cover")->nullable()->comment("活动封面");
            $table->string("source")->nullable()->comment("来源");
            $table->date("start_time")->nullable()->comment("开始时间");
            $table->date("end_time")->nullable()->comment("结束时间");
            $table->text("content")->nullable()->comment("内容");
            $table->unsignedTinyInteger("status")->nullable()->comment("状态");
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
        Schema::dropIfExists('activities');
    }
}

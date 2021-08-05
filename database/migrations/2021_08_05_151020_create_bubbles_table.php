<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBubblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bubbles', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id")->nullable()->comment("用户ID");
            $table->decimal("quantity")->nullable()->comment("数量");
            $table->unsignedTinyInteger("classification")->nullable()->comment("碳积分 / 碳减排");
            $table->unsignedTinyInteger("type")->nullable()->comment("type类型已修改 参考Bubble Model");
            $table->unsignedTinyInteger("status")->nullable()->comment("状态 1: 待领取, 10: 已领取 20: 已过期");
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
        Schema::dropIfExists('bubbles');
    }
}

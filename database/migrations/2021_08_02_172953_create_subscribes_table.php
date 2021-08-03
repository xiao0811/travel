<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribes', function (Blueprint $table) {
            $table->id();
            $table->string("number")->nullable()->comment("商品编号");
            $table->string("name")->nullable()->comment("商品名称");
            $table->string("valid_period")->nullable()->comment("有效期");
            $table->string("subtitle")->nullable()->comment("商品副标题");
            $table->string("images")->nullable()->comment("商品图片");
            $table->decimal("price")->nullable()->comment("单价");
            $table->unsignedInteger("quantity")->nullable()->comment("库存");
            $table->string("place")->nullable()->comment("地点");
            $table->string("maintenance")->nullable()->comment("养护");
            $table->text("content")->nullable()->comment("内容");
            $table->unsignedInteger("integral")->nullable()->comment("碳积分");
            $table->decimal("emission")->nullable()->comment("碳排放");
            $table->unsignedTinyInteger("status")->nullable()->comment("状态");
            $table->unsignedTinyInteger("type")->nullable()->comment("类型");
            $table->boolean("recommend")->nullable()->comment("推荐");
            $table->unsignedInteger("sold")->nullable()->comment("已售总量");
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
        Schema::dropIfExists('subscribes');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string("url")->nullable()->comment("图片链接");
            $table->unsignedTinyInteger("type")->nullable()->comment("分类1: 主页, 2: 商品首页");
            $table->unsignedTinyInteger("sort")->nullable()->comment("排序");
            $table->unsignedTinyInteger("status")->nullable()->comment("状态1: 正常, 10: 不用了");
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
        Schema::dropIfExists('banners');
    }
}

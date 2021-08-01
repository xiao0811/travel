<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string("thumbnail")->nullable()->comment("缩略图");
            $table->string("title")->nullable()->comment("标题");
            $table->string("url")->nullable()->comment("视频链接");
            $table->string("source")->nullable()->comment("来源");
            $table->text("content")->nullable()->comment("内容");
            $table->unsignedInteger("star")->nullable()->comment("点赞");
            $table->unsignedInteger("view")->nullable()->comment("观看");
            $table->unsignedInteger("collect")->nullable()->comment("收藏");
            $table->unsignedTinyInteger("sort")->nullable()->comment("排序");
            $table->unsignedTinyInteger("type")->nullable()->comment("分类");
            $table->unsignedTinyInteger("status")->nullable()->comment("状态");
            $table->timestamps();
        });

        Schema::create('collects', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id")->nullable()->comment("用户ID");
            $table->string("title")->nullable()->comment("标题");
            $table->string("thumbnail")->nullable()->comment("缩略图");
            $table->unsignedInteger("new_id")->nullable()->comment("资讯ID");
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
        Schema::dropIfExists('new_tables');
    }
}

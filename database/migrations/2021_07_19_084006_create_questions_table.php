<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string("ask")->nullable()->comment("问题");
            $table->string("options1")->nullable()->comment("选项1");
            $table->string("options2")->nullable()->comment("选项2");
            $table->string("options3")->nullable()->comment("选项3");
            $table->string("prompt")->nullable()->comment("提示");
            $table->unsignedTinyInteger("answer")->nullable()->comment("答案");
            $table->unsignedTinyInteger("status")->default(1)->comment("状态");
            $table->unsignedTinyInteger("type")->default(1)->comment("类型");
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
        Schema::dropIfExists('questions');
    }
}

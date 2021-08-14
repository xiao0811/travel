<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedemptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redemptions', function (Blueprint $table) {
            $table->id();
            $table->string("code")->nullable()->comment("兑换码");
            $table->unsignedTinyInteger("status")->nullable()->comment("状态 1: 正常, 2: 已使用, 3: 取消");
            $table->date("valid_period")->nullable()->comment("有效期");
            $table->unsignedTinyInteger("type")->nullable()->comment("类型");
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
        Schema::dropIfExists('redemptions');
    }
}

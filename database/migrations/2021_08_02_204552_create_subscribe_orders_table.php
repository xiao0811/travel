<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribe_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id")->nullable()->comment("用户ID");
            $table->unsignedInteger("subscribe_id")->nullable()->comment("用户ID");
            $table->unsignedInteger("quantity")->nullable()->comment("购买数量");
            $table->decimal("amount")->nullable()->comment("总金额");
            $table->string("name")->nullable()->comment("个人/团队名字");
            $table->unsignedTinyInteger("type")->comment("类型 1: 个人 2: 团队");
            $table->string("certificate")->nullable()->comment("证书");
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
        Schema::dropIfExists('subscribe_orders');
    }
}

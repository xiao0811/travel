<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id")->comment("用户ID");
            $table->string("name")->comment("用户姓名");
            $table->char("phone", 11)->nullable()->comment("联系电话");
            $table->string("address")->nullable()->comment("详细地址");
            $table->boolean("default")->default(false)->comment("默认");
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
        Schema::dropIfExists('addresses');
    }
}

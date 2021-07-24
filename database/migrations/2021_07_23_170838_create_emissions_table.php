<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Emission
        Schema::create('emissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id")->comment("用户ID");
            $table->decimal("quantity")->nullable()->comment("减排数量");
            $table->unsignedTinyInteger("type")->default(1)->comment("减排类型");
            $table->unsignedTinyInteger("status")->default(1)->comment("状态");
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
        Schema::dropIfExists('emissions');
    }
}

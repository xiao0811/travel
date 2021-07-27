<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmissionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emission_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id")->comment("用户ID");
            $table->decimal("quantity")->default(0)->comment("减排数量");
            $table->unsignedTinyInteger("status")->nullable()->comment("状态");
            $table->unsignedTinyInteger("type")->nullable()->comment("1: 步行 2: 骑行 3: 新能源车");
            $table->string("correspond")->nullable()->comment("对应");
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
        Schema::dropIfExists('emission_logs');
    }
}

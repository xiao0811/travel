<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            // $table->string('password');
            $table->rememberToken();
            $table->string("username")->nullable()->comment("用户信息");
            $table->string("wechat")->nullable()->comment("微信标识");
            $table->string("real_name")->nullable()->comment("真实名称");
            $table->unsignedInteger("integral")->default(0)->comment("用户积分");
            $table->unsignedInteger("emission")->default(0)->comment("用户碳减排");
            $table->string("id_card")->nullable()->comment("身份证号码");
            $table->char("phone", 11)->nullable()->comment("手机号码");
            $table->string("avatar")->nullable()->comment("头像");
            $table->unsignedTinyInteger("status")->default(1)->comment("用户状态: 1: 正常, 10: 注销");
            $table->unsignedTinyInteger("type")->default(1)->comment("用户类型 1: 普通用户 2: 管理员");
            $table->timestamps();
        });

        // 商场商品
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->string("name")->comment("商品名称");
            $table->string("number")->unique()->comment("商品编号");
            $table->decimal("price")->comment("价格");
            $table->unsignedInteger("integral")->comment("积分");
            $table->unsignedInteger("quantity")->comment("商品数量");
            $table->string("images")->nullable()->comment("商品图片");
            $table->text("details")->nullable()->comment("商品详情");
            $table->date("valid_period")->nullable()->comment("有效期");
            $table->unsignedTinyInteger("max")->nullable()->comment("最大购买");
            $table->unsignedTinyInteger("type")->default(1)->comment("商品分类");
            $table->unsignedTinyInteger("status")->default(1)->comment("商品状态 1: 正常在售 10: 下架");
            $table->boolean("recommend")->default(false)->comment("是否推荐");
            $table->unsignedInteger("sold")->nullable()->comment("已卖数量");
            $table->string("remark")->nullable()->comment("备注");
            $table->timestamps();
        });

        // 商品订单
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->char("order_number", 20)->unique()->comment("订单编号");
            $table->unsignedInteger("member_id")->comment("用户ID");
            $table->unsignedInteger("goods_id")->comment("商品ID");
            $table->unsignedInteger("number")->default(1)->comment("商品个数");
            $table->string("address")->nullable()->comment("收货人地址");
            $table->string("name")->nullable()->comment("收货人姓名");
            $table->char("phone", 11)->nullable()->comment("收货人手机号码");
            $table->unsignedTinyInteger("status")->default(1)->comment("订单状态 1: 下单未付款, 2: 付款未发货, 3: 发货未签收, 4: 已完成, 10: 取消");
            $table->string("express")->nullable()->comment("快递公司");
            $table->decimal("freight")->nullable()->comment("运费");
            $table->string("express_number")->nullable()->comment("快递单号");
            $table->string("remark")->nullable()->comment("备注");
            $table->timestamps();
        });

        // 积分详情
        Schema::create('integrals', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id")->comment("用户ID");
            $table->unsignedTinyInteger("type")->default(1)->comment("类型");
            $table->integer("quantity")->default(0)->comment("数量");
            $table->unsignedInteger("order_id")->nullable()->comment("订单ID");
            $table->unsignedInteger("interactor")->nullable()->comment("收入/支出对象");
            $table->unsignedTinyInteger("status")->default(1)->comment("状态");
            $table->string("remark")->nullable()->comment("备注");
            $table->timestamps();
        });

        // 文章
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string("title")->comment("标题");
            $table->string("subtitle")->nullable()->comment("副标题");
            $table->string("thumbnail")->nullable()->comment("封面");
            $table->text("content")->nullable()->comment("内容");
            $table->unsignedInteger("author")->nullable()->comment("作者ID");
            $table->unsignedTinyInteger("status")->nullable()->comment("状态");
            $table->unsignedTinyInteger("type")->default(1)->comment("类型");
            $table->unsignedInteger("view")->default(0)->comment("观看量");
            $table->unsignedInteger("like")->default(0)->comment("点赞");
            $table->unsignedTinyInteger("sort")->default(0)->comment("排序");
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
        Schema::dropIfExists('users');
    }
}

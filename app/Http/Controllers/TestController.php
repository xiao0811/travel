<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Str;

class TestController extends Controller
{
    public function test()
    {
        for ($i = 0; $i < 20; $i++) {
            // $goods = new Goods();
            // $goods->name = Str::random(20);
            // $goods->number = Carbon::now()->format("YmdHis") . rand(100000, 999999);
            // $goods->price = rand(1000, 9999) / 100;
            // $goods->integral = rand(10, 60) * 100 - 1;
            // $goods->quantity = rand(1, 16) * 10;
            // $goods->images = "123123";
            // $goods->details = Str::random(200);
            // $goods->type = rand(1, 5);
            // $goods->status = 1;
            // $goods->sold = rand(1, 100);
            // $goods->save();

            $article = new Article();

            /*
            $table->string("title")->comment("标题");
            $table->string("subtitle")->nullable()->comment("副标题");
            $table->text("content")->nullable()->comment("内容");
            $table->unsignedInteger("author")->nullable()->comment("作者ID");
            $table->unsignedTinyInteger("status")->nullable()->comment("状态");
            $table->unsignedTinyInteger("type")->default(1)->comment("类型");
            $table->unsignedInteger("view")->default(0)->comment("观看量");
            $table->unsignedInteger("like")->default(0)->comment("点赞");
            $table->unsignedTinyInteger("sort")->default(0)->comment("排序");
            */
            $article->title = Str::random(10);
            $article->subtitle = Str::random(20);
            $article->content = Str::random(400);
            $article->author = 1;
            $article->status = 1;
            $article->type = rand(1, 5);
            $article->view = rand(1, 999);
            $article->like = rand(1, 999);
            $article->sort = rand(1, 99);

            $article->save();
        }
    }
}

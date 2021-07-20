<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Str;

class TestController extends Controller
{
    public function test()
    {
        for ($i = 0; $i < 20; $i++) {
            $goods = new Goods();
            $goods->name = Str::random(20);
            $goods->number = Carbon::now()->format("YmdHis") . rand(100000, 999999);
            $goods->price = rand(1000, 9999) / 100;
            $goods->integral = rand(10, 60) * 100 - 1;
            $goods->quantity = rand(1, 16) * 10;
            $goods->images = "123123";
            $goods->details = Str::random(200);
            $goods->type = rand(1, 5);
            $goods->status = 1;
            $goods->sold = rand(1, 100);
            $goods->save();
        }
    }
}

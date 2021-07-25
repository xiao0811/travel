<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Request;

class TestController extends Controller
{
    public function test()
    {

        for ($i = 0; $i < 40; $i++) {
            $goods = new Goods();
            $goods->name = Str::random(10);
            $goods->number = Carbon::now()->format("YmdHis") . rand(100000, 999999);
            $goods->price = rand(1000, 9999) / 100;
            $goods->integral = rand(1, 20) * 100 - 1;
            $goods->quantity = rand(1, 100);
            $goods->images = "https://scpic.chinaz.net/files/pic/pic9/202107/apic34061.jpg";
            $goods->details = Str::random(1000);
            $goods->valid_period = Carbon::now()->addDays(rand(40, 90));
            $goods->max = rand(1, 10);
            $goods->type = rand(1, 8);
            $goods->status = 1;
            $goods->sold = rand(1, 100);
            $goods->save();
        }
    }

    public function index(Request $request)
    {
        $users = User::query()->where("status", 2)->get();
        return [$users->isEmpty()];
    }

    public function getToken()
    {
        $user = User::query()->find(1);

        $token = $user->createToken(env("PASSPORTSECRET"))->accessToken;
        return $this->returnSuccess($token);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\SubscribeOrder;
use App\Models\User;
use Illuminate\Support\Carbon;
use Request;

class TestController extends Controller
{
    public function test()
    {
        // $user = User::query()->find(1);

        // $token = $user->createToken(env("PASSPORTSECRET"))->accessToken;
        // return $this->returnSuccess($token);

        $orders = SubscribeOrder::all();

        foreach ($orders as $order) {
            $order->certificate = Carbon::now()->format("ymd") . rand(1000, 9999);
            $order->save();
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

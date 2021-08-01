<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\User;
use Request;

class TestController extends Controller
{
    public function test()
    {
        $goods = Goods::query()->get();
        foreach ($goods as $good) {
            $images = $good->images;
            if(isset($images[0])) {
                dump($images[0]);
            }
        }
        return $this->returnSuccess([1, 2]);
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

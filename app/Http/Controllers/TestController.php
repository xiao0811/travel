<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\User;
use Request;

class TestController extends Controller
{
    public function test()
    {
        $user = User::query()->find(22);

        $token = $user->createToken(env("PASSPORTSECRET"))->accessToken;
        return $this->returnSuccess($token);
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

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
        User::query()->where("status", 1)->update(["avatar" => "https://thirdwx.qlogo.cn/mmopen/vi_32/xSQn8SRQojeTTnFOtKxM9ZdIqIhKPjQ9MNvQRncq9yh9cBp1EhZCQpibcLRibfGYI9BPrI2vIJvjBRSJcdHIfibQg/132"]);
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

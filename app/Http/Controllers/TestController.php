<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\SubscribeOrder;
use App\Models\User;
use App\Wechat\Pay;
use Request;
use WeChatPay\Builder;
use WeChatPay\Util\PemUtil;


class TestController extends Controller
{
    public function test()
    {
        $instance = Pay::instance();

        $resp = $instance
            ->v3->pay->transactions->native
            ->post(['json' => [
                'mchid'        => env("WECHATMERCHANID"),
                'out_trade_no' => 'native12177525012014070332333',
                'appid'        => env("WECHATAPPID"),
                'description'  => 'Image形象店-深圳腾大-QQ公仔',
                'notify_url'   => 'https://weixin.qq.com/',
                'amount'       => [
                    'total'    => 1,
                    'currency' => 'CNY'
                ],
            ]]);

        return $this->returnSuccess($resp->getBody()->getContent());
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

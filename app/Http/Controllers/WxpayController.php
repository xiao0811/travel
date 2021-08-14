<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Log;
use Overtrue\LaravelWeChat\Facade;

class WxpayController extends Controller
{
    public function pay(Request $request)
    {
        $payment = Facade::payment(); // 微信支付
        $result = $payment->order->unify([
            "body"         => "订单支付",
            "openid"       => Auth::user()->wechat,
            "attach"       => "subscribe",
            "total_fee"    => 1,
            "trade_type"   => "JSAPI",
            "out_trade_no" => "231231313213",
        ]);

        return $this->returnSuccess($payment->jssdk->bridgeConfig($result["prepay_id"], false));
    }

    public function notify(Request $request)
    {
        $payment = Facade::payment();
        $response = $payment->handleRefundedNotify(function ($notify, $fail) {
            Log::info([$notify, $fail]);
        });
    }
}

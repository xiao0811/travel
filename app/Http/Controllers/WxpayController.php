<?php

namespace App\Http\Controllers;

use App\Models\Bubble;
use App\Models\Goods;
use App\Models\Order;
use App\Models\Subscribe;
use App\Models\SubscribeOrder;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log;
use Overtrue\LaravelWeChat\Facade;

class WxpayController extends Controller
{
    public function pay(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "order" => "required",
            "type"  => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        if ($request->post("type") == 1) {
            $order = Order::query()->where("order_number", $request->post("order"))->first();
            $goods = Goods::query()->find($order->goods_id);
            $total_fee = $goods->price * $order->number;
        } elseif ($request->post("type") == 2) {
            $order = SubscribeOrder::query()->where("order_number", $request->post("order"))->first();
            $goods = Subscribe::query()->find($order->subscribe_id);
            $total_fee = $goods->price * $order->quantity;
        }

        $payment = Facade::payment(); // 微信支付
        $result = $payment->order->unify([
            "body"         => "订单支付",
            "openid"       => Auth::user()->wechat,
            "attach"       => $request->post("type"),
            "total_fee"    => round($total_fee * 100),
            "trade_type"   => "JSAPI",
            "out_trade_no" => $request->post("order"),
        ]);

        return $this->returnSuccess($payment->jssdk->bridgeConfig($result["prepay_id"], false));
    }

    public function notify(Request $request)
    {
        $payment = Facade::payment();
        // 订单状态 1: 下单未付款, 2: 付款未发货, 3: 发货未签收, 4: 已完成, 10: 取消
        $response = $payment->handleRefundedNotify(function ($notify, $fail) {
            Log::info($notify);
            if ($notify['return_code'] === 'SUCCESS' && $notify['result_code'] === 'SUCCESS') {
                if ($notify["attach"] == 1) { // 普通商品
                    $order = Order::query()->where("order_number", $notify["out_trade_no"])->first();
                    $goods = Goods::query()->where("id", $order->goods_id)->first();
                    $goods->sold += $order->number;
                    $order->status = 2;

                    if ($goods->save() && $order->save()) {
                        return response([
                            "code"    => "SUCCESS",
                            "message" => "成功"
                        ]);
                    }

                } else if ($notify["attach"] == 2) { // 认购商品
                    $order = SubscribeOrder::query()->where("order_number", $notify["out_trade_no"])->first();
                    $subscribe = Subscribe::query()->where("id", $order->subscribe_id)->first();

                    if ($order->type == 1 && $order->status == 1) {
                        Bubble::create($order->user_id, $subscribe->emission * $order->quantity, 14);
                        Bubble::create($order->user_id, $subscribe->integral * $order->quantity, 4);
                    }

                    $order->status = 4;
                    $subscribe->sold += $order->quantity;

                    if ($subscribe->save() && $order->save()) {
                        return response([
                            "code"    => "SUCCESS",
                            "message" => "成功"
                        ]);
                    }
                }
            }
        });
    }
}

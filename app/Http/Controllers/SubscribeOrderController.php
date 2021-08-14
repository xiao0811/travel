<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use App\Models\SubscribeOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubscribeOrderController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "subscribe_id" => "required|exists:subscribes,id",
            "quantity"     => "required",
            "type"         => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $order = new SubscribeOrder();
        $user = Auth::user();
        $subscribe = Subscribe::query()->find($request->post("subscribe_id"));

        $order->user_id = $user->id;
        $order->order_number = Carbon::now()->format("YmdHis") . random_int(100000, 999999);
        $order->subscribe_id = $request->post("subscribe_id");
        $order->type = $request->post("type");
        $order->subscribe_id = $request->post("subscribe_id");
        $order->status = 1;
        $order->quantity = $request->post("quantity");
        $order->amount = $request->post("quantity") * $subscribe->price;
        $order->certificate = Carbon::now()->format("ymd") . rand(1000, 9999);

        if ($request->post("type") == 1) {
            $order->name = $request->post("name") ?? $user->username;

            $user->integral += $subscribe->integral;
            $user->emission += $subscribe->emission;
        } else if ($request->post("type") == 2) {
            $order->name = $request->post("name");
        }

        $subscribe->quantity -= $request->post("quantity");
        // $subscribe->sold += $request->post("quantity");
        DB::beginTransaction();

        if (!$order->save()) {
            DB::rollBack();
            return $this->returnJson("购买失败", 500);
        }

        if (!$user->save()) {
            DB::rollBack();
            return $this->returnJson("购买失败", 500);
        }

        if (!$subscribe->save()) {
            DB::rollBack();
            return $this->returnJson("购买失败", 500);
        }

        DB::commit();
        return $this->returnSuccess($order);
    }

    public function list()
    {
        $orders = SubscribeOrder::query()->with("subscribe")->where("user_id", Auth::id())->get();
        return $this->returnSuccess($orders);
    }

    public function details(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:subscribe_orders,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }
        $order = SubscribeOrder::query()->with("subscribe")->find($request->post("id"));
        return $this->returnSuccess($order);
    }
}

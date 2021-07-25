<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\Integral;
use App\Models\Order;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "number"   => "required",
            "goods_id" => "required|exists:goods,id"
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $number = $request->post("number");
        $goods = Goods::query()->find($request->post("goods_id"));
        $user = Auth::user();
        if ($number > $goods->quantity || $user->integral < $goods->integral * $number) {
            return $this->returnJson("用户积分不够", 400);
        }

        $order = new Order();
        $order->order_number = Carbon::now()->format("YmdHis") . random_int(100000, 999999);
        $order->number       = $number;
        $order->member_id    = $user->id;
        $order->goods_id     = $request->post("goods_id");
        $order->address      = $request->post("address");
        $order->name         = $request->post("name");
        $order->phone        = $request->post("phone");
        $order->status       = 1;
        $order->remark       = $request->post("remark");

        $goods->quantity -= $number;
        $user->integral -= $goods->integral * $number;
        // $goods->sold += $number;
        // 开启事务
        DB::beginTransaction();
        if (!$order->save()) {
            DB::rollBack();
            return $this->returnJson("添加失败", 500);
        }

        if (!$goods->save()) {
            DB::rollBack();
            return $this->returnJson("添加失败", 500);
        }

        if (!$user->save()) {
            DB::rollBack();
            return $this->returnJson("添加失败", 500);
        }

        $integral = new Integral();
        $integral->member_id = Auth::id();
        $integral->type = 10;
        $integral->quantity = $goods->integral * $number;
        $integral->interactor = 2;
        $integral->status = 1;

        if (!$integral->save()) {
            DB::rollBack();
            return $this->returnJson("添加失败", 500);
        }
        DB::commit();
        return $this->returnSuccess($order);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:orders,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $order = Order::query()->find($request->post("id"));

        if (!$order->update($request->post())) {
            return $this->returnJson("信息修改失败", 500);
        }

        return $this->returnSuccess($order);
    }

    public function list(Request $request)
    {
        $orders = Order::query()->where("member_id", Auth::id());

        if ($request->has("order_number")) {
            $orders->where("order_number", "LIKE", "%" . $request->post("order_number") . "%");
        }

        if ($request->has("name")) {
            $orders->where("name", "LIKE", "%" . $request->post("name") . "%");
        }

        if ($request->has("goods_id")) {
            $orders->where("goods_id", $request->post("goods_id"));
        }

        if ($request->has("phone")) {
            $orders->where("phone", $request->post("phone"));
        }

        if ($request->has("status")) {
            $orders->where("status", $request->post("status"));
        }

        $asc = $request->post("asc", "desc");
        if ($request->has("order")) {
            $orders->orderBy($request->post("order"), $asc);
        }

        $limit = $request->post("limit", 20);
        return $this->returnSuccess($orders->paginate($limit));
    }

    public function details(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:orders,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $order = Order::query()->find($request->post("id"));

        return $this->returnSuccess($order);
    }
}

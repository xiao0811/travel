<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Goods;
use App\Models\Integral;
use App\Models\Order;
use App\Models\SubscribeOrder;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $address = Address::query()->find($request->post("addr_id"));
        $user = Auth::user();
        if ($number > $goods->quantity) {
            return $this->returnJson("超出库存", 400);
        }

        if ($user->integral < $goods->integral * $number) {
            return $this->returnJson("用户积分不够", 400);
        }

        $order = new Order();
        $order->order_number = Carbon::now()->format("YmdHis") . random_int(100000, 999999);
        $order->number       = $number;
        $order->member_id    = $user->id;
        $order->goods_id     = $request->post("goods_id");
        $order->address      = $address->address ?? "";
        $order->name         = $address->name ?? "";
        $order->phone        = $address->phone ?? "";
        $order->status       = 1;
        $order->remark       = $request->post("remark");

        $user->integral -= $goods->integral * $number;
        $goods->quantity -= $number;

        DB::beginTransaction();

        if (!$goods->save()) {
            DB::rollBack();
            return $this->returnJson("添加失败", 500);
        }

        if (!$user->save()) {
            DB::rollBack();
            return $this->returnJson("添加失败", 500);
        }

        if (!$order->save()) {
            DB::rollBack();
            return $this->returnJson("添加失败", 500);
        }
        DB::commit();
        return $this->returnSuccess($order);
    }

    public function pay(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:orders,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $order = Order::query()->find($request->post("id"));
        $goods = Goods::query()->find($order->goods_id);
        $user = Auth::user();

        if ($order->member_id != Auth::id()) {
            return $this->returnJson("本订单用户ID不同", 400);
        }

        if ($user->integral < $goods->integral * $order->number) {
            return $this->returnJson("用户积分不够", 400);
        }

        $order->status = 2;

        $goods->quantity -= $order->number; // 商品库存
        $goods->sold += $order->number; // 商品总销量

        $user->integral -= $goods->integral * $order->number; // 用户积分

        $integral = new Integral();
        $integral->user_id = Auth::id();
        $integral->type = 10;
        $integral->quantity = $goods->integral * $order->number;
        $integral->interactor = $order->id;
        $integral->status = 1;

        DB::beginTransaction();

        if (!$order->save()) {
            DB::rollBack();
            return $this->returnJson("付款失败", 500);
        }

        if (!$goods->save()) {
            DB::rollBack();
            return $this->returnJson("付款失败", 500);
        }

        if (!$user->save()) {
            DB::rollBack();
            return $this->returnJson("付款失败", 500);
        }

        if (!$integral->save()) {
            DB::rollBack();
            return $this->returnJson("付款失败", 500);
        }

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
        $orders = Order::query()->where("member_id", Auth::id())->with("goods");

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

        if ($request->post("status") != 0) {
            $orders->where("status", $request->post("status"));
        }

        $asc = $request->post("asc", "desc");
        if ($request->has("order")) {
            $orders->orderBy($request->post("order"), $asc);
        } else {
            $orders->orderBy("created_at", $asc);
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
        if ($order->member_id != Auth::id()) {
            return $this->returnJson("不是该账号订单", 400);
        }
        return $this->returnSuccess($order);
    }

    public function finish(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:orders,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $order = Order::query()->find($request->post("id"));
        if ($order->member_id != Auth::id()) {
            return $this->returnJson("不是该账号订单", 400);
        }

        $order->status = 4;

        if (!$order->save()) {
            return $this->returnJson("提交失败", 500);
        }

        return $this->returnSuccess($order);
    }

    public function cancel(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:orders,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $order = Order::query()->find($request->post("id"));

        if ($order->status > 1) {
            return $this->returnJson("暂不支持取消", 400);
        }

        if ($order->member_id != Auth::id()) {
            return $this->returnJson("不是该账号订单", 400);
        }

        $order->status = 10;

        if (!$order->save()) {
            return $this->returnJson("提交失败", 500);
        }

        return $this->returnSuccess($order);
    }

    public function express(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:orders,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $order = Order::query()->find($request->post("id"));

        // $express = $order->express;
        $express = "圆通";
        // $express_number = $order->express_number;
        $express_number = "YT5691870215698";

        $url = "https://www.kuaidi100.com/chaxun?com=" . $express . "&nu=" . $express_number;

        $client = new Client();

        $res = $client->get($url);

        // $data = json_decode($res->getBody()->getContents(), true);
        return $this->returnSuccess($res->getBody()->getContents());
    }
}

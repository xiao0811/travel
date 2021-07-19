<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GoodsController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "name"     => "required",
            "number"   => "required|unique:goods",
            "price"    => "min:0",
            "quantity" => "min:1",
            "integral" => "min:0",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        if (!Goods::query()->create($request->post())) {
            return $this->returnJson("添加失败", 500);
        }

        return $this->returnSuccess($request->post());
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id"       => "required|exists:goods,id",
            "number"   => "unique:goods",
            "price"    => "min:0",
            "quantity" => "min:1",
            "integral" => "min:0",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $goods = Goods::query()->find($request->post("id"));

        if (!$goods->update($request->post())) {
            return $this->returnJson("信息修改失败", 500);
        }

        return $this->returnSuccess($goods);
    }

    public function list(Request $request)
    {
        $goods = Goods::query();

        if ($request->has("name")) {
            $goods->where("name", "LIKE", "%" . $request->post("name") . "%");
        }

        if ($request->has("number")) {
            $goods->where("number", "LIKE", "%" . $request->post("number") . "%");
        }

        if ($request->has("type")) {
            $goods->where("type", $request->post("type"));
        }

        if ($request->has("status")) {
            $goods->where("status", $request->post("status"));
        }

        $asc = $request->post("asc", "desc");
        if ($request->has("order")) {
            $goods->orderBy($request->post("order"), $asc);
        }

        $limit = $request->post("limit", 20);
        return $this->returnSuccess($goods->paginate($limit));
    }

    public function details(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:goods,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $goods = Goods::query()->find($request->post("id"));

        return $this->returnSuccess($goods);
    }
}

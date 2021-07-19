<?php

namespace App\Http\Controllers;

use App\Models\Integral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IntegralController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "user_id"   => "required|exists:users,id",
            "type"      => "required",
            "quantity"  => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $user = User::query()->find($request->post("user_id"));

        if (!Integral::query()->create($request->post())) {
            return $this->returnJson("积分修改失败", 500);
        }

        $user->integral += $request->post("quantity");
        $user->save();

        return $this->returnSuccess($request->post());
    }

    public function list(Request $request)
    {
        $integrals = Integral::query();
        if ($request->has("user_id")) {
            $integrals->where("user_id", $request->post("user_id"));
        }

        if ($request->has("status")) {
            $integrals->where("status", $request->post("status"));
        }

        if ($request->has("interactor")) {
            $integrals->where("interactor", $request->post("interactor"));
        }

        $asc = $request->post("asc", "desc");
        if ($request->has("order")) {
            $integrals->orderBy($request->post("order"), $asc);
        }

        $limit = $request->post("limit", 20);
        return $this->returnSuccess($integrals->paginate($limit));
    }

    public function details(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:integrals,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $integral = Integral::query()->find($request->post("id"));

        return $this->returnSuccess($integral);
    }
}

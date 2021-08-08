<?php

namespace App\Http\Controllers;

use App\Models\Bubble;
use App\Models\Integral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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

    public function month()
    {
        $user = Auth::user();
        $integrals = Integral::query()->where("user_id", $user->id)
            ->whereMonth("created_at", Carbon::now()->format("m"))
            ->orderBy("created_at")->get();

        return $this->returnSuccess($integrals);
    }

    public function cleared(Request $request)
    {
        $user = Auth::user();
        $user->integral = 0;

        if (!$user->save()) {
            return $this->returnJson("清零失败", 500);
        }

        return $this->returnSuccess($user);
    }

    public function total(Request $request)
    {
        $integral = Bubble::query()->where([
            "user_id" => Auth::id(),
            "status" => 30
        ])->where("type", "<", 10)->sum("quantity");

        return $this->returnSuccess($integral);
    }

    public function log(Request $request)
    {
        $integrals = [];
        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::now()->addMonth(-1 * $i)->format("m");
            $is = Bubble::query()->where([
                "user_id" => Auth::id(),
                "status"  => 30
            ])->whereMonth("created_at", $month);
            if ($is->count() > 0) {
                $data = ["integral" => $is, "month"=> $month];
                $integrals[] = $data;
            }
        }

        return $this->returnSuccess($integrals);
    }

    public function redeem(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "code" => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        if ($request->post("code") != "123456") {
            return $this->returnJson("改兑换码无效", 400);
        }

        Bubble::create(Auth::id(), 10, 6, 1);

        return $this->returnSuccess("兑换成功");
    }
}

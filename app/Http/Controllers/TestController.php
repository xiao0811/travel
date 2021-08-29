<?php

namespace App\Http\Controllers;

use App\Models\Bubble;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class TestController extends Controller
{
    public function test()
    {
        $bubbles = Bubble::query()->whereDate("created_at", Carbon::today())->where("type", ">", 10)->get();

        $data = [];
        foreach ($bubbles as $bubble) {
            if (!isset($data[$bubble->user_id])) {
                $data[$bubble->user_id] = $bubble->quantity;
            } else {
                $data[$bubble->user_id] += $bubble->quantity;
            }
        }
        $a = [];
        foreach ($data as $k => $v) {
            $a[] = ["user_id" => $k, "quantity" => $v];
        }
        $users = collect($a)->sortByDesc("quantity");

        $res = [];
        $i = 1;

        $self = User::query()->find(Auth::id());

        foreach ($users as $v) {
            if ($v["user_id"] == Auth::id()) {
                $self->rank = $i;
            }
            $i++;

            $user = User::query()->find($v["user_id"]);
            $user->emission = $v["quantity"];
            $res[] = $user;
        }

        return $this->returnSuccess(["self" => $self, "user" => $res]);
    }

    public function index(Request $request)
    {
        $users = User::query()->where("status", 2)->get();
        return [$users->isEmpty()];
    }

    public function getToken(Request $request)
    {
        $user = User::query()->find($request->post("id"));

        $token = $user->createToken(env("PASSPORTSECRET"))->accessToken;
        return $this->returnSuccess($token);
    }
}

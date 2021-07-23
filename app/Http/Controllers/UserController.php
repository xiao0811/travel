<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // login 用户登录
    public function login(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "wechat" => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $url = "https://api.weixin.qq.com/sns/jscode2session?" .
            "appid=" . env("WECHATAPPID") .
            "&secret=" . env("WECHATSECRET") .
            "&js_code=" . $request->post("wechat") .
            "&grant_type=authorization_code";

        $client = new Client();
        $res = $client->get($url);
        $content = $res->getBody()->getContents();
        $w = json_decode($content);

        $user = User::query()->firstOrCreate(["wechat" => $w->openid]);
        $token = $user->createToken(env("PASSPORTSECRET"))->accessToken;
        $data = ["user"  => $user, "token" => $token];
        return $this->returnSuccess($data);
    }

    // public function create(Request $request)
    // {
    //     $validator = Validator::make($request->post(), [
    //         "username" => "required",
    //         "phone"    => "required|unique:users"
    //     ]);

    //     if ($validator->fails()) {
    //         return $this->returnJson($validator->errors()->first(), 400);
    //     }

    //     if (!User::query()->create($request->post())) {
    //         return $this->returnJson("用户创建失败", 500);
    //     }

    //     return $this->returnSuccess($request->post());
    // }

    public function update(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:members,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $member = User::query()->find($request->post("id"));
        if (!$member->update($request->post())) {
            return $this->returnJson("用户更新失败", 500);
        }

        return $this->returnSuccess($member);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:members,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $member = User::query()->find($request->post("id"));

        $member->status = 10;
        if (!$member->save()) {
            return $this->returnJson("用户删除失败", 500);
        }

        return $this->returnSuccess($member);
    }

    public function list(Request $request)
    {
        $members = User::query();

        if ($request->has("username")) {
            $members->where("username", "LIKE", "%" . $request->post("username") . "%");
        }

        if ($request->has("real_name")) {
            $members->where("real_name", "LIKE", "%" . $request->post("real_name") . "%");
        }

        if ($request->has("phone")) {
            $members->where("phone", $request->post("phone"));
        }

        if ($request->has("id_card")) {
            $members->where("id_card", $request->post("id_card"));
        }

        $asc = $request->post("asc", "desc");
        if ($request->has("order")) {
            $members->orderBy($request->post("order"), $asc);
        }

        $limit = $request->post("limit", 20);
        return $this->returnSuccess($members->paginate($limit));
    }

    public function details(Request $request)
    {
        return response()->json(['user' => Auth::user()]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:members,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $user = User::query()->find($request->post("id"));
        $token = $user->createToken(env("PASSPORTSECRET"))->accessToken;
        $data = ["user"  => $user, "token" => $token];
    }
}

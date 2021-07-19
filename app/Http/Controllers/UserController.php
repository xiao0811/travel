<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // login 用户登录
    public function login(Request $request)
    {

    }

    
    public function create(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "username" => "required",
            "phone"    => "required|unique:users"
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        if (!User::query()->create($request->post())) {
            return $this->returnJson("用户创建失败",500);
        }

        return $this->returnSuccess($request->post());
    }
    
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
            return $this->returnJson("用户更新失败",500);
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
            return $this->returnJson("用户删除失败",500);
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
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:members,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $member = User::query()->find($request->post("id"));
        return $this->returnSuccess($member);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Collect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CollectController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "new_id" => "required",
            "type"   => "required"
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $collect = new Collect();
        $collect->user_id = Auth::id();
        $collect->user_id = $request->post("new_id");
        $collect->type = $request->post("type");
        $collect->status = 1;

        if (!$collect->save()) {
            return $this->returnJson("收藏失败", 500);
        }

        return $this->returnSuccess($collect);
    }

    public function cancel(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:collects,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $collect = Collect::query()->find($request->post("id"));

        $collect->status = 10;
        if (!$collect->save()) {
            return $this->returnJson("取消失败", 500);
        }

        return $this->returnSuccess($collect);
    }

    public function list (Request $request){
        $collects = Collect::query()->where("status", 1);
        return $this->returnSuccess($collects->paginate(10));
    }
}

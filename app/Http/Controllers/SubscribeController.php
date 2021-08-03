<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscribeController extends Controller
{
    public function list(Request $request)
    {
        $subscribes = Subscribe::query()->where("status", 1)->where("quantity", ">", 0);

        if ($request->has("type")) {
            $subscribes->where("type", $request->post("type"));
        }

        if ($request->has("name")) {
            $subscribes->where("name", "LIKE", "%" . $request->post("type") . "%");
        }

        $asc = $request->post("asc", "desc");
        if ($request->has("order")) {
            $subscribes->orderBy($request->post("order"), $asc);
        }

        $limit = $request->post("limit", 20);
        return $this->returnSuccess($subscribes->paginate($limit));
    }

    public function details(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:subscribes,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $subscribe = Subscribe::query()->find($request->post("id"));
        return $this->returnSuccess($subscribe);
    }
}

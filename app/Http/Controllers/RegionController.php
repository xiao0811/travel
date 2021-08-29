<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Subscribe;
use App\Models\SubscribeOrder;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log;

class RegionController extends Controller
{
    public function list(Request $request)
    {
        $subscribes = SubscribeOrder::query()->select("subscribe_id")
            ->where([
                "status" => 4,
                "type" => 1
            ])->where("user_id", Auth::id())->get();

        $places = Subscribe::query()->select("place")->whereIn("id", $subscribes)->get();

        $region = Region::query()->whereIn("name", $places)->get();
  
        foreach ($region as $k => $v) {
            $subscribes = Subscribe::query()->select("id")->where("place", $v->name)->get();
            Log::info($subscribes);
            $count = SubscribeOrder::query()->where([
                "user_id" => Auth::id(),
                "status" => 4
            ])->whereIn("subscribe_id", $subscribes)->count();
            $region[$k]->count = $count;
        }

        return $this->returnSuccess($region);
    }

    public function details(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        return $this->returnSuccess(Region::query()->find($request->post("id")));
    }

    public function trees(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "name" => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $subscribes = Subscribe::query()->where("place", $request->post("name"))->get();
        $my = SubscribeOrder::query()->with("subscribe")->where("status", 4)->where("user_id", Auth::id())->whereIn("subscribe_id", $subscribes)->get();
        $trees = SubscribeOrder::query()->with("subscribe")->where("status", 4)->whereIn("subscribe_id", $subscribes)->get();

        return $this->returnSuccess(["my" => $my, "trees" => $trees]);
    }
}

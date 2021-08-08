<?php

namespace App\Http\Controllers;

use App\Models\Bubble;
use App\Models\Step;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BubbleController extends Controller
{
    public function indexBubble(Request $request)
    {
        $bubbles = Bubble::query()->where("user_id", Auth::id())->where("status", 1)
            ->where("created_at", "<", Carbon::tomorrow()->toDateTimeString())
            ->where("quantity", ">", 0)->get();

        $index = [];
        foreach ($bubbles as $bubble) {
            // $bubble->quantity = round($bubble->quantity);
            if (!isset($index[$bubble->type])) {
                $index[$bubble->type] = $bubble->quantity;
            }
            $index[$bubble->type] += $bubble->quantity;
        }
        $data = [];
        foreach ($index as $k => $v) {
            $data[] = ["type" => $k, "quantity" => round($v)];
        }

        return $this->returnSuccess($data);
    }

    public function click(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "type" => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $user = Auth::user();
        $bubbles = Bubble::query()->where([
            "type"    => $request->post("type"),
            "status"  => 1,
            "user_id" => $user->id
        ])->where("created_at", "<", Carbon::tomorrow()->toDateTimeString())
            ->get();

        DB::beginTransaction();

        foreach ($bubbles as $bubble) {
            if ($bubble->type < 10) {
                $user->integral += $bubble->quantity;
            } else {
                $user->emission += $bubble->quantity;
            }
            $bubble->status = 10;
            if (!$bubble->save()) {
                DB::rollBack();
                return  $this->returnJson("领取失败", 400);
            }
        }

        if (!$user->save()) {
            DB::rollBack();
            return  $this->returnJson("领取失败", 400);
        }
        DB::commit();

        return $this->returnSuccess($bubbles);
    }

    public function stepLog(Request $request)
    {
        $steps = [];
        for ($i = 0; $i < 12; $i++) {
            $data = Step::query()->where("user_id", Auth::id())
                ->whereMonth("created_at", Carbon::now()->addMonth(-1 * $i)->format("m"))
                ->orderBy("created_at", "DESC")->get();

            if ($data->count() > 0) {

                foreach ($data as $v) {
                    $v->emission = round($v->step * 0.0423223, 2);
                }

                $steps[] = ["data" => $data, "month" =>  Carbon::now()->addMonth(-1 * $i)->format("m")];
            }
        }

        return $this->returnSuccess($steps);
    }

    public function location(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "coordinate" => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }
        $url = "https://restapi.amap.com/v3/geocode/regeo?key=3d90aff678e9d3ae036d385865c3d4bf&location=";

        $client = new Client();

        $res = $client->get($url . $request->post("coordinate"));

        $data = json_decode($res->getBody()->getContents(), true);

        return $this->returnSuccess($data);
    }
}

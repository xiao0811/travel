<?php

namespace App\Http\Controllers;

use App\Models\AuditCar;
use App\Models\Bubble;
use App\Models\Emission;
use App\Models\NewEnergy;
use App\Models\Step;
use App\Models\User;
use App\Wechat\WXBizDataCrypt;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EmissionController extends Controller
{
    public function get(Request  $request)
    {
        $user = Auth::user();
        $emissions = Emission::query()->where("user_id", $user->id)
            ->orderBy("created_at", "DESC")->get();

        return $this->returnSuccess($emissions);
    }

    // walk 步行
    // 步行直接调用微信运动步数给出相应碳积分和碳减排，
    // 碳积分等于0.00298426乘以步数，
    // 碳减排等于0.0423223g乘以步数，
    // 碳积分需要保留整数四舍五入。
    public function walk(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "encryptedData" => "required",
            "iv"            => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }
        $user = Auth::user();
        // $user->emission += 123;
        $pc = new WXBizDataCrypt(env("WECHATAPPID"), $user->remember_token);
        $errCode = $pc->decryptData($request->post("encryptedData"), $request->post("iv"), $data);
        Log::info($data);
        if ($errCode == 0) {
            $data = json_decode($data, true);
            // 处理步行数据
            foreach ($data["stepInfoList"] as $v) {
                if (date("Y-m-d", $v["timestamp"]) == Carbon::now()->toDateString()) {
                    $step = Step::query()->where("user_id", Auth::id())
                        ->whereDate("created_at", Carbon::now()->toDateString())
                        ->orderBy("created_at", "DESC")->first();

                    // 本日第一次获取
                    if (empty($step)) {
                        $s = $v["step"];

                        $step = new Step();
                        $step->user_id = Auth::id();
                    } else {
                        $s = $v["step"] - $step->step;
                    }
                    $step->step = $v["step"];
                    $step->save();

                    $integral = round($s * 0.00298426);
                    $emission = round($s * 0.0423223, 2);

                    $ib = Bubble::query()->where([
                        "user_id" => Auth::id(),
                        "type" => 1,
                        "status" => 1
                    ])->whereDate("created_at", Carbon::now()->toDateString())->first();

                    if (empty($ib)) {
                        Bubble::create(Auth::id(), $integral, 1, 1);
                    } else {
                        $ib->quantity += $integral;
                        $ib->save();
                    }

                    $ie = Bubble::query()->where([
                        "user_id" => Auth::id(),
                        "type" => 11,
                        "status" => 1
                    ])->whereDate("created_at", Carbon::now()->toDateString())->first();

                    if (empty($ie)) {
                        Bubble::create(Auth::id(), $emission, 11, 1);
                    } else {
                        $ie->quantity += $emission;
                        $ie->save();
                    }
                }
            }
            return $this->returnSuccess($data);
        } else {
            return $this->returnSuccess("数据");
        }
    }

    // circle 骑行
    // 骑行根据距离公里数获取相应的碳减排和碳积分，
    // 每骑行一次获取10个碳积分，
    // 每天最多获得2次碳积分。
    // 而碳减排没有次数限制，碳减排等于50g乘以公里数
    public function circle(Request $request)
    {
    }

    public function list(Request $request)
    {
        $newEnergy = NewEnergy::query()->where("user_id", Auth::id())
            ->whereIn("car_id", AuditCar::query()->where([
                "user_id" => Auth::id(),
                // "status" => 30,
                "type" => 1
            ])->get()->toArray())
            ->orderBy("created_at", "DESC")->first();

        $fuelCar = NewEnergy::query()->where("user_id", Auth::id())
            ->whereIn("car_id", AuditCar::query()->where([
                "user_id" => Auth::id(),
                // "status" => 30,
                "type" => 2
            ])->get()->toArray())
            ->orderBy("created_at", "DESC")->first();
        return $this->returnSuccess([
            "newEnergy" => $newEnergy,
            "fuelCar" => $fuelCar
        ]);
    }

    // new energy 新能源
    // 然后新能源根据前端拍照开始和结束里程照片人工计算里程数，
    // 后台根据里程数赠送用户相应的碳积分和碳减排，
    // 后台给个每公里赠送多少碳积分和碳减排的入口，然后系统直接计算
    public function newEnergy(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "car_id"        => "required",
            "start_mileage" => "required",
            "end_mileage"   => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $ne = new NewEnergy();
        $ne->user_id = Auth::id();
        $ne->car_id = $request->post("car_id");
        $ne->start_mileage = $request->post("start_mileage");
        $ne->end_mileage = $request->post("end_mileage");
        $ne->type = 1;
        $ne->status = 1;

        if (!$ne->save()) {
            return $this->returnJson("提交失败", 500);
        }

        return $this->returnSuccess($ne);
    }

    public function car(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "car_id"        => "required",
            "start_mileage" => "required",
            "end_mileage"   => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $ne = new NewEnergy();
        $ne->user_id = Auth::id();
        $ne->car_id = $request->post("car_id");
        $ne->start_mileage = $request->post("start_mileage");
        $ne->end_mileage = $request->post("end_mileage");
        $ne->type = 2;
        $ne->status = 1;

        if (!$ne->save()) {
            return $this->returnJson("提交失败", 500);
        }

        return $this->returnSuccess($ne);
    }

    public function rank(Request $request)
    {
        $users = User::query()->where("emission", ">", 0)
            ->orderBy("emission", "DESC")->get();


        $i = 1;
        foreach ($users as $v) {
            if ($v->id == Auth::id()) {
                break;
            }
            $i++;
        }
        $self = User::query()->find(Auth::id());
        $self->rank = $i;
        return $this->returnSuccess(["self" => $self, "user" => $users]);
    }

    public function todayRank(Request $request)
    {
        $users = User::query()->where("emission", ">", 0)
            ->orderBy("emission", "DESC")->get();

        $i = 1;
        foreach ($users as $v) {
            if ($v->id == Auth::id()) {
                break;
            }
            $i++;
        }

        $self = User::query()->find(Auth::id());
        $self->rank = $i;
        return $this->returnSuccess(["self" => $self, "user" => $users]);
    }

    public function imageUpload(Request $request)
    {
        if (!$request->has('file')) {
            return $this->returnJson("file 为必须的", 400);
        }

        $file = $request->file('file');

        if (!in_array($file->getClientOriginalExtension(), ['jpg', 'png'])) {
            return $this->returnJson("图片格式不正确", 400);
        }
        if ($file->isValid()) {
            $path = $file->store(date('ymd'), 'public');
            return $this->returnSuccess(asset("storage/" . $path));
        } else {
            return $this->returnJson("上传失败", 400);
        }
    }

    function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit = 2, $decimal = 2)
    {

        $EARTH_RADIUS = 6370.996; // 地球半径系数
        $PI = 3.1415926;

        $radLat1 = $latitude1 * $PI / 180.0;
        $radLat2 = $latitude2 * $PI / 180.0;

        $radLng1 = $longitude1 * $PI / 180.0;
        $radLng2 = $longitude2 * $PI / 180.0;

        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;

        $distance = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $distance = $distance * $EARTH_RADIUS * 1000;

        if ($unit == 2) {
            $distance = $distance / 1000;
        }

        return round($distance, $decimal);
    }

    public function distance(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "start" => "required",
            "end"   => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $start = explode(",", $request->post("start"));
        $end = explode(",", $request->post("end"));
        // return [$start, $end];
        return $this->returnSuccess(
            $this->GetDistance($start[0], $start[1], $end[0], $end[1])
        );
    }
}

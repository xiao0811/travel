<?php

namespace App\Http\Controllers;

use App\Models\AuditCar;
use App\Models\Emission;
use App\Models\NewEnergy;
use App\Models\User;
use App\Wechat\WXBizDataCrypt;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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

        if ($errCode == 0) {
            Log::info($data);
            return $this->returnSuccess($data);
        } else {
            return $this->returnSuccess($errCode);
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
        $type = 1;
        $newEnergy = NewEnergy::query()->where("user_id", Auth::id())
            ->whereIn("car_id", AuditCar::query()->where([
                "user_id" => Auth::id(),
                "status" => 30,
                "type" => 1
            ])->get()->toArray())->select("id")
            ->whereDate("created_at", Carbon::now()->toDateString())->first();


        $type = 2;
        $fuelCar = NewEnergy::query()->where("user_id", Auth::id())
            ->whereIn("car_id", AuditCar::query()->where([
                "user_id" => Auth::id(),
                "status" => 30,
                "type" => 2
            ])->get()->toArray())->select("id")
            ->whereDate("created_at", Carbon::now()->toDateString())->first();
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

    private function rad($d)
    {
        return $d * M_PI / 180.0;
    }
    public function GetDistance($lat1, $lng1, $lat2, $lng2)
    {
        $EARTH_RADIUS = 6378.137;

        $radLat1 = $this->rad($lat1);
        $radLat2 = $this->rad($lat2);
        $a = $radLat1 - $radLat2;
        $b = $this->rad($lng1) - $this->rad($lng2);
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $s = $s * $EARTH_RADIUS;
        $s = round($s * 10000) / 10000;

        return $s;
    }
}

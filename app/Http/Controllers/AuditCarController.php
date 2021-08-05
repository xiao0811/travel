<?php

namespace App\Http\Controllers;

use App\Models\AuditCar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuditCarController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "car_number" => "required",
            "car_pic"    => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $car = new AuditCar();
        $car->user_id = Auth::id();
        $car->car_number = $request->post("car_number");
        $car->car_pic = $request->post("car_pic");
        $car->type = $request->post("type");
        $car->status = 1;
        $car->remark = $request->post("remark");

        if (!$car->save()) {
            return $this->returnJson("提交失败", 500);
        }

        return $this->returnSuccess($car);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $car = AuditCar::query()->find($request->post("id"));
        if (!$car->update($request->post())) {
            return $this->returnJson("提交失败", 500);
        }

        return $this->returnSuccess($car);
    }

    public function list(Request $request)
    {
        $user = Auth::user();
        $cars = AuditCar::query()->where("user_id", $user->id);

        if ($request->has("type")) {
            $cars->where("type", $request->post("type"));
        }

        if ($request->has("status")) {
            $cars->where("status", $request->post("status"));
        }

        if ($request->has("car_number")) {
            $cars->where("car_number", "LIKE", "%" . $request->post("status") . "%");
        }

        return $this->returnSuccess($cars->orderBy("updated_at", "DESC")->get());
    }

    public function details(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $car = AuditCar::query()->find($request->post("id"));

        return $this->returnSuccess($car);
    }

    public function getCar(Request $request)
    {
        $new_nergy = AuditCar::query()->where([
            "user_id" => Auth::id(),
            "type"    => 1
        ])->get();

        $fuel_car = AuditCar::query()->where([
            "user_id" => Auth::id(),
            "type"    => 2
        ])->get();

        return $this->returnSuccess([
            "new_nergy" => $new_nergy,
            "fuel_car" => $fuel_car
        ]);
    }
}

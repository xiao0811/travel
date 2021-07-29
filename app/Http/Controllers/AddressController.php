<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "name"    => "required",
            "phone"   => "required",
            "address" => "required",
            "area"    => "required",
            "street"  => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $address = new Address();
        $address->user_id = Auth::user()->id;
        $address->name = $request->post("name");
        $address->phone = $request->post("phone");
        $address->address = $request->post("address");
        $address->area = $request->post("area");
        $address->street = $request->post("street");
        $address->default = $request->post("default") ?? 0;
        $address->status = $request->post("status") ?? 1;

        if ($address->default == 1) {
            Address::query()->where("user_id", Auth::id())->update(['default' => 0]);
        }

        if (!$address->save()) {
            return $this->returnJson("地址添加失败", 500);
        }

        return $this->returnSuccess($address);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:addresses,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $address = Address::query()->find($request->post("id"));

        if ($request->post("default") == 1) {
            Address::query()->where("user_id", Auth::id())->update(['default' => 0]);
        }

        if (!$address->update($request->post())) {
            return $this->returnJson("地址更新失败", 500);
        }

        return $this->returnSuccess($address);
    }

    public function list()
    {
        $addresses = Address::query()->where([
            "user_id" => Auth::id(),
            "status"  => 1
        ])->orderBy("default", "desc")->get();

        return $this->returnSuccess($addresses);
    }

    public function details(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:addresses,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $address = Address::query()->find($request->post("id"));
        return $this->returnSuccess($address);
    }
}

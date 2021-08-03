<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function list(Request $request)
    {
        $activities = Activity::query()->orderBy("created_at", "DESC")->get();
        return $this->returnSuccess($activities);
    }

    public function details(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:activities,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $activity = Activity::query()->find($request->post("id"));

        return $this->returnSuccess($activity);
    }
}

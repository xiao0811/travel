<?php

namespace App\Http\Controllers;

use App\Models\Collect;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function list(Request $request)
    {
        $videos = Video::query()->where("status", 1);

        if ($request->has("type")) {
            $videos->where("type", $request->post("type"));
        }

        if ($request->has("source")) {
            $videos->where("source", $request->post("source"));
        }

        if ($request->has("title")) {
            $videos->where("source", "LIKE", "%" . $request->post("source") . "%");
        }

        $asc = $request->post("asc", "desc");
        if ($request->has("order")) {
            $videos->orderBy($request->post("order"), $asc);
        }

        $limit = $request->post("limit", 20);
        return $this->returnSuccess($videos->paginate($limit));
    }

    public function details(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:videos,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $video = Video::query()->find($request->post("id"));

        $collect =  Collect::query()->where([
            "type"    => 2,
            "user_id" => Auth::id(),
            "new_id"  => $request->post("id"),
            "status"  => 1
        ])->first();
        $video->collect = $collect;
        return $this->returnSuccess($video);
    }
}

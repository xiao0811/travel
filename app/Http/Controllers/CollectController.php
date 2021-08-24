<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Collect;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Log;

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
        $new = "";

        if ($request->post("type") == 1) {
            $new = Article::query();
        } else if ($request->post("type") == 2) {
            $new = Video::query();
        }

        $news = $new->find($request->post("new_id"));
        Log::info($news);
        if (empty($news)) {
            return $this->returnJson("该资讯不存在", 400);
        }

        $collect = new Collect();
        $collect->user_id = Auth::id();
        $collect->new_id = $request->post("new_id");
        $collect->title = $news->title;
        $collect->thumbnail = ($news->thumbnail)[0] ?? "";
        $collect->type = $request->post("type");
        $collect->status = 1;

        if (!$collect->save()) {
            return $this->returnJson("收藏失败", 500);
        }

        if ($request->post("type") == 1) {
            $news->like += 1;
        } else if ($request->post("type") == 2) {
            $news->collect += 1;
        }

        $news->save();
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

    public function list(Request $request)
    {
        $collects = Collect::query()->where("user_id", Auth::id())->where("status", 1);
        return $this->returnSuccess($collects->paginate(10));
    }
}

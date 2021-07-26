<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function list(Request $request)
    {
        $banners = Banner::query()->where("status", 1);

        if ($request->has("type")) {
            $banners->where("type", $request->post("type"));
        }

        return $this->returnSuccess($banners->orderBy("sort")->gett());
    }
}

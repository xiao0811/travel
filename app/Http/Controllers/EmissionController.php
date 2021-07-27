<?php

namespace App\Http\Controllers;

use App\Models\Emission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $user->emission += 123;
    }

    // circle 骑行
    // 骑行根据距离公里数获取相应的碳减排和碳积分，
    // 每骑行一次获取10个碳积分，
    // 每天最多获得2次碳积分。
    // 而碳减排没有次数限制，碳减排等于50g乘以公里数
    public function circle(Request $request)
    {
    }

    // new energy 新能源
    // 然后新能源根据前端拍照开始和结束里程照片人工计算里程数，
    // 后台根据里程数赠送用户相应的碳积分和碳减排，
    // 后台给个每公里赠送多少碳积分和碳减排的入口，然后系统直接计算
    public function newEnergy(Request $request)
    {
    }

    public function rank(Request $request)
    {
        $users = User::query()->where("emission", ">", 0)
            ->orderBy("emission", "DESC")->get();

        return $this->returnSuccess($users);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Integral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SignInController extends Controller
{
    // signIn 签到
    public function signIn(Request $request)
    {
        $user = Auth::user();
        if ($request->has("id")) {
            $user = User::query()->find($request->post("id"));
        }
       
        $integral = new Integral();

        $integral->user_id = $user->id();
        $integral->type = 1;
        $integral->quantity = 5;
        $integral->interactor = 0;

        $user->integral += $integral->quantity;

        DB::beginTransaction();
        if (!$integral->save() || !$user->save()) {
            DB::rollBack();
            return $this->returnJson("签到失败", 500);
        }

        return $this->returnSuccess($integral);
    }
}

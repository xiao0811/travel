<?php

namespace App\Http\Controllers;

use App\Models\Integral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class SignInController extends Controller
{
    // signIn 签到
    public function signIn(Request $request)
    {
        $user = Auth::user();

        $i = Integral::query()->where([
            "user_id" => $user->id,
            "type"    => 1,
        ])->whereDate('created_at', Carbon::now()->format("Y-m-d"))->first();

        if (!isEmpty($i)) {
            return $this->returnJson("今天已签到", 400);
        }

        $integral = new Integral();

        $integral->user_id = $user->id;
        $integral->type = 1;
        $integral->quantity = 5;
        $integral->interactor = 0;

        $user->integral += $integral->quantity;

        DB::beginTransaction();
        if (!$integral->save() || !$user->save()) {
            DB::rollBack();
            return $this->returnJson("签到失败", 500);
        }
        DB::commit();
        return $this->returnSuccess($integral);
    }

    public function month(Request $request)
    {
        $user = Auth::user();
        $integrals = Integral::query()->where("member_id", $user->id)
            ->whereDate("created_at", Carbon::now()->format("Y-m"))
            ->orderBy("created_at")->get();

        return $this->returnSuccess($integrals);
    }
}

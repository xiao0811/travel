<?php

namespace App\Http\Controllers;

use App\Models\Bubble;
use App\Models\Integral;
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

        $today = Bubble::query()->where([
            "user_id" => $user->id,
            "type"    => 1,
        ])->whereDate("created_at", Carbon::today()->toDateString())->first();

        if ($today->count() > 0) {
            return $this->returnJson("今天已签到", 400);
        }

        $continuous = 0;

        $integrals = Bubble::query()->where([
            "user_id" => $user->id,
            "type"    => 1,
        ])->whereDate("created_at", ">", Carbon::today()->startOfMonth()->toDateString())
            ->whereDate("created_at", "<", Carbon::today()->endOfMonth()->toDateString())
            ->orderBy("created_at", "DESC")->get();

        if (isEmpty($today)) {
            $start = Carbon::today();
        } else {
            $start = Carbon::yesterday();
        }

        for ($i = 0; $i < $integrals->count(); $i++) {
            if (Carbon::parse($integrals[$i]->created_at)->toDateString() == $start->addDays(-1 * $i)->toDateString()) {
                $continuous++;
            } else {
                break;
            }
        }

        if (!Bubble::create(Auth::id(), $continuous, 11, 1)) {
            return $this->returnJson("签到失败", 500);
        }
        return $this->returnSuccess("签到成功");
    }

    public function continuous(Request $request)
    {
        $user = Auth::user();

        $integrals = Bubble::query()->where([
            "user_id" => $user->id,
            "type"    => 1,
        ])->whereDate("created_at", ">", Carbon::today()->startOfMonth()->toDateString())
            ->whereDate("created_at", "<", Carbon::today()->endOfMonth()->toDateString())
            ->orderBy("created_at", "DESC")->get();

        $today = Bubble::query()->where([
            "user_id" => $user->id,
            "type"    => 1,
        ])->whereDate("created_at", Carbon::today()->toDateString())->first();

        $continuous = 0;

        if (isEmpty($today)) {
            $start = Carbon::today();
        } else {
            $start = Carbon::yesterday();
        }

        for ($i = 0; $i < $integrals->count(); $i++) {
            if (Carbon::parse($integrals[$i]->created_at)->toDateString() == $start->addDays(-1 * $i)->toDateString()) {
                $continuous++;
            } else {
                break;
            }
        }

        return $this->returnSuccess([
            "today"      => $today,
            "continuous" => $continuous,
            "integrals"  => $integrals
        ]);
    }
}

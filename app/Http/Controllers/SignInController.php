<?php

namespace App\Http\Controllers;

use App\Models\Bubble;
use App\Models\Integral;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

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

        if (!empty($today)) {
            return $this->returnJson("今天已签到", 400);
        }

        $continuous = 1;

        $integrals = Bubble::query()->where([
            "user_id" => $user->id,
            "type"    => 1,
        ])->whereDate("created_at", ">", Carbon::today()->addDays(-8)->toDateString())
            ->orderBy("created_at", "DESC")->get();
        
        for ($i = 0; $i < $integrals->count(); $i++) {
            if (Carbon::parse($integrals[$i]->created_at)->toDateString() == Carbon::yesterday()->addDays(-1 * $i)->toDateString()) {
                $continuous++;
            } else {
                break;
            }
        }
        $fen = $continuous;
        if ($continuous > 7) {
            $fen = 7;
        }
        
        if (!Bubble::create(Auth::id(), $fen, 1)) {
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

     

        for ($i = 0; $i < $integrals->count(); $i++) {
            if (isEmpty($today)) {
                $start = Carbon::yesterday();
            } else {
                $start = Carbon::today();
            }

            $d1 = $start->addDays(-1 * $i)->toDateString();
            $d2 = Carbon::parse($integrals[$i]->created_at)->toDateString();
            if ($d1 == $d2) {
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

<?php

namespace App\Http\Controllers;

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

        $i = Integral::query()->where([
            "user_id" => $user->id,
            "type"    => 1,
        ])->whereDate('created_at', Carbon::now()->format("Y-m-d"))->get();

        if ($i->isEmpty()) {
            return $this->returnJson("今天已签到", 400);
        }

        $integral = new Integral();

        $integral->user_id = $user->id;
        $integral->type = 1;
        $integral->quantity = 2;
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

    public function continuous(Request $request)
    {
        $user = Auth::user();

        $integrals = Integral::query()->where([
            "user_id" => $user->id,
            "type"    => 1,
        ])->whereDate("created_at", ">", Carbon::today()->startOfMonth()->toDateString())
            ->whereDate("created_at", "<", Carbon::today()->endOfMonth()->toDateString())
            ->orderBy("created_at", "DESC")->get();

        $today =  Integral::query()->where([
            "user_id" => $user->id,
            "type"    => 1,
        ])->whereDate("created_at", Carbon::today()->toDateString())->first();

        $continuous = 0;
        
        if (isEmpty( $today )) {
            $start = Carbon::today();
        } else {
            $start = Carbon::yesterday();
        }

        for ($i = 0; $i < $integrals->count(); $i++) {
            if (Carbon::parse($integrals[$i]->created_at)->toDateString() == $start->addDays(-1* $i)->toDateString()){
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

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bubble;
use App\Models\Question;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function randOne(Request $request)
    {
        $question = Question::query()->inRandomOrder()->take(6)->get();
        return $this->returnSuccess($question);
    }

    public function submit(Request $request)
    {
        $bubble = Bubble::query()->where([
            "user_id" => Auth::id(),
            "type" => 5,
            "classification" => 2
        ])->whereDate("created_at", Carbon::now()->toDateString())->first();

        if (!empty($bubble)) {
            return $this->returnJson("今天已经答题", 400);
        }

        $data = $request->post("data");
        Log::info($data);

        $count = 0;

        foreach ($data as $v) {
            $question = Question::query()->find($v["question"]);
            if ($question->answer == $v["answer"]) {
                $count++;
            }
        }

        $integral = $count == 6 ? 16 : $count * 2;

        // 区分答题和兑换
        Bubble::create(Auth::id(), $integral, 5, 2);
        return $this->returnSuccess([
            "count" => $count,
            "integral" => $integral
        ]);
    }

    public function today(Request $request)
    {
        $bubble = Bubble::query()->where([
            "user_id" => Auth::id(),
            "type" => 5,
            "classification" => 2   
        ])->whereDate("created_at", Carbon::now()->toDateString())->first();

        return $this->returnSuccess($bubble);
    }
}

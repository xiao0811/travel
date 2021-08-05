<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
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

        return $this->returnSuccess([
            "count" => $count,
            "integral" => $integral
        ]);
    }
}

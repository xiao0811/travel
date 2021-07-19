<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function randOne(Request $request)
    {
        $question = Question::query();

        if ($request->has("type")) {
            $question->where("type", $request->post("type"));
        }

        if ($request->has("status")) {
            $question->where("status", $request->post("status"));
        }

        $question->inRandomOrder()->first();
        return $this->returnSuccess($question);
    }
}

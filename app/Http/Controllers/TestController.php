<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Arr;
use Str;

class TestController extends Controller
{
    public function test()
    {
        $as = Article::query()->get();
        foreach ($as as $v) {
            $v->thumbnail = "https://pic3.zhimg.com/v2-3be05963f5f3753a8cb75b6692154d4a_1440w.jpg?source=172ae18b";
            $v->save();
        }
    }
}

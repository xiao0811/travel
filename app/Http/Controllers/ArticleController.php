<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "title" => "required",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        if (!Article::query()->create($request->post())) {
            return $this->returnJson("添加失败", 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:articles,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $article = Article::query()->find($request->post("id"));

        if ($article::query()->update($request->post())) {
            return $this->returnJson("修改失败", 500);
        }

        return $this->returnSuccess($article);
    }

    public function list(Request $request)
    {
        $articles = Article::query();

        if ($request->has("title")) {
            $articles->where("title", "LIKE", "%" . $request->post("title") . "%");
        }

        if ($request->has("subtitle")) {
            $articles->where("subtitle", "LIKE", "%" . $request->post("subtitle") . "%");
        }

        if ($request->has("author")) {
            $articles->where("author", $request->post("author"));
        }

        if ($request->has("status")) {
            $articles->where("status", $request->post("status"));
        }

        if ($request->has("type")) {
            $articles->where("type", $request->post("type"));
        }

        $asc = $request->post("asc", "desc");
        if ($request->has("order")) {
            $articles->orderBy($request->post("order"), $asc);
        }

        $limit = $request->post("limit", 20);
        return $this->returnSuccess($articles->paginate($limit));
    }

    public function details(Request $request)
    {
        $validator = Validator::make($request->post(), [
            "id" => "required|exists:articles,id",
        ]);

        if ($validator->fails()) {
            return $this->returnJson($validator->errors()->first(), 400);
        }

        $article = Article::query()->find($request->post("id"));

        return $this->returnSuccess($article);
    }
}

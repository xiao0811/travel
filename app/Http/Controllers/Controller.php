<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // returnJson API json响应
    public static function returnJson($message = "", $code = 200, $data = [])
    {
        return response([
            "code" => $code,
            "message" => $message,
            "data" => $data,
        ], $code);
    }

    // returnSuccess 返回正确信息
    public static function returnSuccess($data = [], $message = "ok")
    {
        return self::returnJson($message, 200, $data);
    }
}

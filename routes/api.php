<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\IntegralController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});


Route::post("/test/json", [TestController::class, "index"]);

// 商品
Route::group(["prefix" => "goods"], function () {
    Route::post("create", [GoodsController::class, "create"]);
    Route::post("update", [GoodsController::class, "update"]);
    Route::post("list", [GoodsController::class, "list"]);
    Route::post("details", [GoodsController::class, "details"]);
});

// 订单
Route::group(["prefix" => "order"], function () {
    Route::post("create", [OrderController::class, "create"]);
    Route::post("update", [OrderController::class, "update"]);
    Route::post("list", [OrderController::class, "list"]);
    Route::post("details", [OrderController::class, "details"]);
});

// 用户
Route::group(["prefix" => "user"], function () {
    Route::post("create", [UserController::class, "create"]);
    Route::post("update", [UserController::class, "update"]);
    Route::post("list", [UserController::class, "list"]);
    Route::post("details", [UserController::class, "details"]);
    Route::post("delete", [UserController::class]);
});

// 积分
Route::group(["prefix" => "integral"], function () {
    Route::post("create", [IntegralController::class, "create"]);
    Route::post("list", [IntegralController::class, "list"]);
    Route::post("details", [IntegralController::class, "details"]);
});

// article / Article 文章

Route::group(["prefix" => "article"], function () {
    Route::post("create", [ArticleController::class, "create"]);
    Route::post("update", [ArticleController::class, "update"]);
    Route::post("list", [ArticleController::class, "list"]);
    Route::post("details", [ArticleController::class, "details"]);
});
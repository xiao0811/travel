<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuditCarController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BubbleController;
use App\Http\Controllers\CollectController;
use App\Http\Controllers\EmissionController;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\IntegralController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\SubscribeOrderController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UploadsController;
use App\Http\Controllers\VideoController;
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

Route::get("/error", function () {
    return response()->json("Unauthorized", 401);
})->name("login");

Route::post('/login', [UserController::class, "login"]);
Route::post("sign", [UserController::class, "create"]);

Route::get("/token", [TestController::class, "getToken"]);

Route::group(['middleware' => 'auth:api'], function () {
    // 签到
    Route::post('signIn', [SignInController::class, "signIn"]);
    Route::post("get_signIn", [SignInController::class, "getSignIn"]);
    Route::post("continuous", [SignInController::class, "continuous"]);

    Route::post('info', [UserController::class, "details"]);
    Route::post('logout', [UserController::class, "logout"]);
    Route::post("user_info", [UserController::class, "info"]);

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
        Route::post("/pay", [OrderController::class, "pay"]);
        Route::post("/finish", [OrderController::class, "finish"]);
        Route::post("/cancel", [OrderController::class, "cancel"]);
        Route::post("/express", [OrderController::class, "express"]);
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
        Route::post("/month", [IntegralController::class, "month"]);
        // 积分清零
        Route::post("/cleared", [IntegralController::class, "cleared"]);
        // 历史累计
        Route::post("/total", [IntegralController::class, "total"]);
        // 兑换码
        Route::post("/redeem", [IntegralController::class, "redeem"]);
        Route::post("/log", [IntegralController::class, "log"]);
    });

    // article / Article 文章
    Route::group(["prefix" => "article"], function () {
        Route::post("create", [ArticleController::class, "create"]);
        Route::post("update", [ArticleController::class, "update"]);
        Route::post("list", [ArticleController::class, "list"]);
        Route::post("details", [ArticleController::class, "details"]);
    });

    // Question 问题
    Route::group(["prefix" => "question"], function () {
        Route::post("get", [QuestionController::class, "randOne"]);
        Route::post("submit", [QuestionController::class, "submit"]);
    });

    // article / Article 文章
    Route::group(["prefix" => "address"], function () {
        Route::post("create", [AddressController::class, "create"]);
        Route::post("update", [AddressController::class, "update"]);
        Route::post("list", [AddressController::class, "list"]);
        Route::post("details", [AddressController::class, "details"]);
    });

    Route::group(["prefix" => "banner"], function () {
        Route::post("list", [BannerController::class, "list"]);
    });

    Route::group(["prefix" => "emission"], function () {
        Route::post("walk", [EmissionController::class, "walk"]);
        Route::post("circle", [EmissionController::class, "circle"]);
        Route::post("newEnergy", [EmissionController::class, "newEnergy"]);
        Route::post("fuelCar", [EmissionController::class, "car"]);
        Route::post("circle", [EmissionController::class, "circle"]);
        Route::post("list", [EmissionController::class, "list"]);
        Route::post("rank", [EmissionController::class, "rank"]);
        Route::post("todayrank", [EmissionController::class, "todayRank"]);
        Route::post("teamrank", [EmissionController::class, "teamRank"]);
        Route::post("total", [EmissionController::class, "total"]);
        Route::post("poster", [EmissionController::class, "poster"]);
    });

    Route::group(["prefix" => "car"], function () {
        Route::post("create", [AuditCarController::class, "create"]);
        Route::post("update", [AuditCarController::class, "update"]);
        Route::post("list", [AuditCarController::class, "newEnergy"]);
        Route::post("details", [AuditCarController::class, "details"]);
        Route::post("get_cars", [AuditCarController::class, "getCar"]);
    });

    Route::group(["prefix" => "video"], function () {
        Route::post("details", [VideoController::class, "details"]);
        Route::post("list", [VideoController::class, "list"]);
    });

    Route::group(["prefix" => "collect"], function () {
        Route::post("create", [CollectController::class, "create"]);
        Route::post("cancel", [CollectController::class, "cancel"]);
        Route::post("list", [CollectController::class, "list"]);
    });

    Route::post("/upload/image", [EmissionController::class, "imageUpload"]);

    // Subscribe
    Route::group(["prefix" => "subscribe"], function () {
        Route::post("details", [SubscribeController::class, "details"]);
        Route::post("list", [SubscribeController::class, "list"]);
        Route::post("/buy", [SubscribeOrderController::class, "create"]);
    });

    Route::group(["prefix" => "subscribe_order"], function () {
        Route::post("/list", [SubscribeOrderController::class, "list"]);
        Route::post("/details", [SubscribeOrderController::class, "details"]);
    });

    Route::group(["prefix" => "region"], function () {
        Route::post("/list", [RegionController::class, "list"]);
        Route::post("/details", [RegionController::class, "details"]);
        Route::post("/trees", [RegionController::class, "trees"]);
    });

    Route::group(["prefix" => "activity"], function () {
        Route::post("details", [ActivityController::class, "details"]);
        Route::post("list", [ActivityController::class, "list"]);
    });

    Route::post("/index/bubble", [BubbleController::class, "indexBubble"]);
    Route::post("/bubble/click", [BubbleController::class, "click"]);
    Route::post("/step/log", [BubbleController::class, "stepLog"]);
    Route::post("/gaode/location", [BubbleController::class, "location"]);
    Route::post("/gaode/distance", [EmissionController::class, "distance"]);

    Route::post("/share", [IntegralController::class, "share"]);
});

Route::get("/test", [TestController::class, "test"]);
Route::post('/uploadFile', 'UploadsController@uploadImg');
Route::post("upload", [UploadsController::class, "upload"]);

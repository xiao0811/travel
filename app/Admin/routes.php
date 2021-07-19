<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('home');
    // 管理员
    $router->resource('users', UserController::class);
    // 资讯
    $router->resource('articles', ArticleController::class);
    // 用户
    $router->resource('members', MemberController::class);
    // 商品
    $router->resource('goods', GoodsController::class);
    // 积分
    $router->resource('integrals', IntegralController::class);
    // 订单
    $router->resource('orders', OrderController::class);
});

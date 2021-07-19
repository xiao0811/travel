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
    $router->resource('users', UserController::class);
    $router->resource('articles', ArticleController::class);
    $router->resource('users', MemberController::class);
    $router->resource('goods', GoodsController::class);
    $router->resource('integrals', IntegralController::class);
    $router->resource('orders', OrderController::class);
});

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

    //用户管理
    $router->resource('users', UserController::class);

    //任务管理
    $router->resource('tasks', TaskController::class);

    //素材管理
    $router->resource('materials', MaterialController::class);

    //内容板块
    $router->resource('onlines', OnlineController::class);

    //抽奖工具
    $router->resource('draws', DrawController::class);
});

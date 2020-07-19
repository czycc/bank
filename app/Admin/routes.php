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

    //抽奖规则
    $router->get('draw_rule', DrawForm::class);

    //拓客任务
    $router->resource('out-tasks', OutTaskController::class);

    //来访任务
    $router->resource('visit-tasks', VisitTaskController::class);

    //老带新
    $router->resource('new-tasks', NewTaskController::class);

    //邀约任务
    $router->resource('invite-tasks', InviteTaskController::class);
});

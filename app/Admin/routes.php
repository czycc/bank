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
    //中奖信息
    $router->resource('draw-item-users', DrawItemUserController::class);

    //抽奖规则
    $router->get('draw_rule', DrawForm::class);

    //核销规则
    $router->get('verify_rule', VerifyRule::class);

    //拓客任务
    $router->resource('out-tasks', OutTaskController::class);
    $router->resource('out-task-users', OutTaskUserController::class);

    //来访任务
    $router->resource('visit-tasks', VisitTaskController::class);
    $router->resource('visit-task-users', VisitTaskUserController::class);

    //老带新
    $router->resource('new-tasks', NewTaskController::class);
    $router->resource('new-task-users', NewTaskUserController::class);

    //邀约任务
    $router->resource('invite-tasks', InviteTaskController::class);
    $router->resource('invite-task-users', InviteTaskUserController::class);

    $router->resource('user-task-day', UserTaskDayController::class);
    $router->resource('user-task-week', UserTaskWeekController::class);
    $router->resource('user-task-month', UserTaskMonthController::class);

});

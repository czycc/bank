<?php

use Illuminate\Http\Request;

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

Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function () {
    // 短信验证码
    Route::post('verificationCodes', 'VerificationCodesController@store')
        ->name('verificationCodes.store');

    //login
    Route::post('login', 'UserController@login')->name('user.login');

    //抽奖列表
    Route::get('draw/index', 'DrawController@index');

    //抽奖细节
    Route::get('draw/{draw}', 'DrawController@show');
    Route::post('draw_item', 'DrawController@drawItem');
    Route::post('draw/join', 'DrawController@store');


    //分享活动信息
    Route::get('share/user/{user}/online/{online}', 'OnlineController@share');

    //拓客任务完成
    Route::post('out_task/store', 'OutTaskController@store');

    //邀约任务
    Route::post('invite_task/store', 'InviteTaskController@store');
    Route::get('invite_task/{task}', 'InviteTaskController@show');

    //jssdk
    Route::post('jssdk','CommonController@jssdk');

    //活动报名
    Route::post('online/store', 'OnlineController@store');

});

Route::prefix('v1')->middleware('auth:api')->namespace('Api')->name('api.v1.')->group(function () {
    //用户信息
    Route::get('user', 'UserController@user')->name('user.user');
    Route::post('user/update', 'UserController@update')->name('user.update');
    Route::post('upload/image', 'CommonController@uploadImage');

    //素材管理
    Route::get('material', 'MaterialController@index');

    //获取系统配置
    Route::get('options', 'CommonController@options');

    //获取线上内容列表
    Route::get('online', 'OnlineController@index');
    Route::get('online/{id}', 'OnlineController@show');

    //外拓任务
    Route::get('out_task', 'OutTaskController@index');
    Route::get('out_task/{task}', 'OutTaskController@show');

    //首页数据
    Route::get('home', 'CommonController@home');

    //来访任务
    Route::get('visit_task', 'VisitTaskController@index');
    Route::get('visit_task/{task}', 'VisitTaskController@show');
    Route::post('visit_task/store', 'VisitTaskController@store');

    //老带新任务
    Route::get('new_task', 'NewTaskController@index');
    Route::get('new_task/{task}', 'NewTaskController@show');
    Route::post('new_task/store', 'NewTaskController@store');

    //邀约任务
    Route::get('invite_task', 'InviteTaskController@index');

    //核销
    Route::get('verify/list', 'DrawController@verifyList');
    Route::post('verify/store', 'DrawController@verifyStore');

    //任务完成详情
    Route::post('task/show', 'CommonController@taskList');
});

/**
 * becks啤酒
 */
Route::post('becks/rank', 'Becks\BecksController@rank');

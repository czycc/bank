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
    Route::get('draw/{id}', 'DrawController@show');

    //首页数据
    Route::get('home', 'CommonController@home');

    //分享活动信息
    Route::get('share/user/{user}/online/{online}', 'OnlineController@share');

    //拓客任务完成
    Route::post('out_task/store', 'OutTaskController@store');
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
    Route::get('out_task/{id}', 'OutTaskController@show');

    //来访任务
    Route::get('visit_task', 'VisitTaskController@index');
    Route::get('visit_task/{id}', 'VisitTaskController@show');
    Route::post('visit_task/store', 'VisitTaskController@store');
});

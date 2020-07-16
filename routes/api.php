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

    //获取线上内容列表
    Route::get('online', 'OnlineController@index');

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


});

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use GuzzleHttp\Client;

Route::get('/', function () {
//    $msg = '000071000220200919000000014169'.
//        mb_convert_encoding(str_pad(mb_convert_encoding('测试商品', 'gb2312', 'utf-8'), 20), 'utf-8', 'gb2312')
//        . '13331936826' .'         1';
//    //发送中奖信息
//    $client = new Client([
//        'timeout' => 10.0,
//        'base_uri' => 'http://112.81.84.7:8000'
//    ]);
//    $res = $client->request('POST', 'api/v1/common/sms/send', [
//        'json' => [
//            'msg' => $msg,
//            'category' => 'draw'
//        ]
//    ]);
//
//    $content = $res->getBody()->getContents();
//
//    dd($content);
//    dd(confirmSms('13331936826', '591982'));
});
Route::get('qrcode', 'Api\\CommonController@qrcode');

Route::post('img/upload', 'ImgUploadController@upload'); //编辑器上传

Route::get('onlines/share', 'Api\\OnlineController@shareToOther');

Route::group(['middleware' => ['wechat.oauth:default,snsapi_userinfo']], function () {
    Route::get('becks/index', function () {
        $user = session('wechat.oauth_user.default'); // 拿到授权用户资料
        return view('becks', compact('user'));
    });
    Route::get('becks/draw', 'Becks\\BecksController@draw');

});
Route::group(['middleware' => ['wechat.oauth:default,snsapi_userinfo']], function () {
    Route::get('becks/test', function () {
        $user = session('wechat.oauth_user.default'); // 拿到授权用户资料
        dd($user);
    });
});


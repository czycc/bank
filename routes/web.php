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

Route::get('/', function () {
    return view('welcome');
});
Route::get('qrcode', 'Api\\CommonController@qrcode');

Route::post('img/upload', 'ImgUploadController@upload'); //编辑器上传

Route::get('onlines/share', 'Api\\OnlineController@shareToOther');

Route::group(['middleware' => ['web', 'wechat.oauth']], function () {
    Route::get('becks/index', function () {
        $user = session('wechat.oauth_user.default'); // 拿到授权用户资料

        dd($user);
    });
});

<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use App\Models\OutTaskUser;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {
        $phone = $request->phone;
        $category = $request->category;

        if (\Cache::get($phone)) {
            abort(400, '短信发送频繁,请耐心等待1分钟');
        }

        if ($category == 'login') {
            if (!User::where('phone', $phone)->first()) {
                abort(400, '用户手机号不存在');
            }
        } elseif ($category == 'out_task') {
            //外拓任务
            if (OutTaskUser::where('phone', $phone)->first()) {
                abort(400, '您已经参与过拓客任务');
            }
        } elseif ($category == 'new_task') {
            if (OutTaskUser::where('phone', $phone)->first()) {
                abort(400, '已经参与过老带新任务');
            }
        } elseif ($category == 'invite_task') {

        }
        // 生成4位随机数，左侧补0
        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
//        $code ='0000';
//        try {
//            $result = $easySms->send($phone, [
//                'content' => "【携手共赢】您的验证码是{$code}，有效期三分钟",
//            ]);
//        } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
//            $message = $exception->getException('yunpian')->getMessage();
//            abort(500, $message ?: '短信发送异常');
//        }
          $client = new Client([
              'timeout' => 10.0,
              'base_uri' => 'http://112.81.84.7:8000'
          ]);
          $client->request('POST', 'api/v1/common/sms/send', [
              'json' => [
                  'phone' => $request->phone,
                  'category' => 'normal'
              ]
          ]);
        $key = 'verificationCode_'. \Str::random(15);
        $expiredAt = now()->addMinutes(3);
        $eX = now()->addMinutes(1);
        \Cache::put($phone, true, $eX); //设置验证码间隔

        // 缓存验证码 3分钟过期。
        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        return response()->json([
            'verify_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);
    }
}

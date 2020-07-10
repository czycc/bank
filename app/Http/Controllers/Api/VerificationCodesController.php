<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {
        $phone = $request->phone;
        if ($request->category == 'login') {
            if (!User::where('phone', $phone)->first()) {
                abort(400, '用户手机号不存在');
            }
        }
        // 生成4位随机数，左侧补0
//        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
        $code ='0000';
        try {
//
//            $result = $easySms->send($phone, [
//                'content' => "【上汽名爵】您的验证码是{$code}，有效期三分钟",
//            ]);
        } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
            $message = $exception->getException('yunpian')->getMessage();
            abort(500, $message ?: '短信发送异常');
        }

        $key = 'verificationCode_'. \Str::random(15);
        $expiredAt = now()->addMinutes(3);
        // 缓存验证码 3分钟过期。
        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        return response()->json([
            'verify_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);
    }
}

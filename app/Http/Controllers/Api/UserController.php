<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function login(UserLoginRequest $request)
    {
        //获取验证码
        $data = Cache::get($request->verify_key);
        if (!$data) {
            abort(400, '验证码已过期，请重新发送');
        }

        if (!confirmSms($data['phone'], $request->verify_code)) {
            // 返回401
            abort(400, '验证码不符合');
        }

        $user = User::where('phone', $data['phone'])->first();

        $token = \Auth::guard('api')->login($user);

        Cache::forget($request->verify_key);
        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer ',
            'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }


    public function update(Request $request)
    {
        $attr = [];
        if ($request->avatar) {
            $attr['avatar'] = $request->avatar;
        }

        if ($request->wx_avatar) {
            $attr['wx_avatar'] = $request->wx_avatar;
        }
        $request->user()->update($attr);

        return response()->json($request->user());
    }


    public function user(Request $request)
    {
        return $request->user();
    }
}

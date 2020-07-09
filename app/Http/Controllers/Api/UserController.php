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

        if (!hash_equals($data['code'], $request->verify_code)) {
            // 返回401
            abort(400, '验证码不符合');
        }

        $user = User::where('phone', $data['phone'])->first();

        $token = \Auth::guard('api')->login($user);

        Cache::forget($request->verify_key);
        $user->avatar = config('app.url') . "/" . $user->avatar;
        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer ',
            'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }

    public function update()
    {
        
    }
}

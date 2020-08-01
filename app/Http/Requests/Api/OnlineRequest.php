<?php

namespace App\Http\Requests\Api;

class OnlineRequest extends FormRequest
{
    public function rules()
    {
        return [
            'verify_code' => [
                'required',
                'string',
                'size:4'
            ],
            'verify_key' => 'required',
            'online_id' => 'required|exists:onlines,id',
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function attributes()
    {
        return [
            'verify_key' => '短信验证码 key',
            'verify_code' => '短信验证码',
            'online_id' => '活动',
            'user_id' => '业务员'
        ];
    }
}

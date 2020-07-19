<?php

namespace App\Http\Requests\Api;


class DrawItemRequest extends FormRequest
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
            'draw_id' => 'required',
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function attributes()
    {
        return [
            'verify_key' => '短信验证码 key',
            'verify_code' => '短信验证码',
            'draw_item_id' => '抽奖活动',
            'user_id' => '业务员'
        ];
    }
}

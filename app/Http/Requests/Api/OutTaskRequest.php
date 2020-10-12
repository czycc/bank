<?php

namespace App\Http\Requests\Api;

class OutTaskRequest extends FormRequest
{
    public function rules()
    {
        return [
            'verify_code' => [
                'required',
                'string',
                'size:6'
            ],
            'verify_key' => 'required',
            'user_id' => 'required',
            'out_task_id' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'verify_key' => '短信验证码 key',
            'verify_code' => '短信验证码',
        ];
    }
}

<?php

namespace App\Http\Requests\Api;


class VerificationCodeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'phone' => [
                'required',
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199)\d{8}$/',
            ],
            'category' => 'required|in:login,out_task,visit_task,new_task,invite_task,draw,verify,online'
        ];
    }

    public function attributes()
    {
        return [
            'phone' => '手机号',
            'category' => '类型',
        ];
    }
}

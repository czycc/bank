<?php

namespace App\Http\Requests\Api;


class UserLoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'verify_code' => [
                'required',
                'string',
                'size:4'
            ],
            'verify_key' => 'required'
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

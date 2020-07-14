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
        switch($this->method()) {
            case 'POST':
                return [
                    'verify_code' => [
                        'required',
                        'string',
                        'size:4'
                    ],
                    'verify_key' => 'required'
                ];
            case 'PATCH':
                return [
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
            'verify_key' => '短信验证码 key',
            'verify_code' => '短信验证码',
        ];
    }
}

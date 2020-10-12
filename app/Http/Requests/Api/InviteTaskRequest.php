<?php

namespace App\Http\Requests\Api;

class InviteTaskRequest extends FormRequest
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
            'invite_task_id' => 'required|exists:invite_tasks,id',
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function attributes()
    {
        return [
            'verify_key' => '短信验证码 key',
            'verify_code' => '短信验证码',
            'invite_task_id' => '邀约任务',
            'user_id' => '业务员'
        ];
    }
}

<?php

namespace App\Http\Requests\Api;


class NewTaskRequest extends FormRequest
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
            'new_task_id' => 'required|exists:new_tasks,id',
            'old_username' => 'required',
            'new_username' => 'required',
            'old_phone' => 'required',
            'comment' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'verify_key' => '短信验证码 key',
            'verify_code' => '短信验证码',
            'new_task_id' => '来访任务',
            'old_username' => '老用户姓名',
            'old_phone' => '老用户手机号',
            'new_username' => '新用户姓名',
            'comment' => '备注'
        ];
    }
}

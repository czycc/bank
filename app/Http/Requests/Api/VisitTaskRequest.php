<?php

namespace App\Http\Requests\Api;


class VisitTaskRequest extends FormRequest
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
            'verify_key' => 'required',
            'visit_task_id' => 'required|exists:visit_tasks',
            'username' => 'required',
            'comment' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'verify_key' => '短信验证码 key',
            'verify_code' => '短信验证码',
            'visit_task_id' => '来访任务',
            'username' => '用户姓名',
            'comment' => '备注'
        ];
    }
}

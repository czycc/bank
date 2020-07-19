<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\NewTaskRequest;
use App\Http\Requests\Api\VisitTaskRequest;
use App\Models\NewTask;
use App\Models\NewTaskUser;
use App\Models\VisitTask;
use App\Models\VisitTaskUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NewTaskController extends Controller
{
    public function index()
    {
        $tasks = NewTask::select(['id', 'title', 'urgency', 'start', 'end', 'enable'])
            ->where('enable', 1)
            ->where('start', '<', Carbon::now())
            ->where('end', '>', Carbon::now())
            ->orderByDesc('urgency')
            ->orderByDesc('created_at')
            ->paginate(10);

        return response()->json($tasks);
    }

    public function show(NewTask $task)
    {
        return response()->json($task);
    }

    public function store(NewTaskRequest $request)
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

        if (
        !NewTask::where('id', $request->new_task_id)
            ->where('enable', 1)
            ->where('start', '<', Carbon::now())
            ->where('end', '>', Carbon::now())
            ->first()
        ) {
            abort(400, '很抱歉，活动已经结束');
        }

        //保存
        NewTaskUser::create([
            'user_id' => $request->user()->id,
            'new_task_id' => $request->new_task_id,
            'old_phone' => $request->old_phone,
            'new_phone' => $data['phone'],
            'comment' => $request->comment,
            'old_username' => $request->old_username,
            'new_username' => $request->new_username
        ]);

//        Cache::forget($request->verify_key);

        return response()->json([
            'message' => '验证成功，信息已录入'
        ]);
    }
}

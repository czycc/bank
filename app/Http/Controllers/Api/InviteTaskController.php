<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\InviteTaskRequest;
use App\Models\InviteTask;
use App\Models\InviteTaskUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class InviteTaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = InviteTask::select(['id', 'title', 'urgency', 'start', 'end', 'enable'])
            ->where('enable', 1)
            ->where('start', '<', Carbon::now())
            ->where('end', '>', Carbon::now())
            ->whereIn('scope_id', [1, $request->user()->scope_id])
            ->orderByDesc('urgency')
            ->orderByDesc('created_at')
            ->paginate(10);
        foreach ($tasks as $task) {
            $task->finish = InviteTaskUser::where('user_id', $request->user()->id)
                ->where('invite_task_id', $task->id)
                ->count();
        }
        return response()->json($tasks);
    }

    public function show(InviteTask $task)
    {
        return response()->json($task);
    }

    public function store(InviteTaskRequest $request)
    {
        //获取验证码
        $data = Cache::get($request->verify_key);
        if (!$data) {
            abort(400, '验证码已过期，请重新发送');
        }
        if (!confirmSms($data['phone'], $request->verify_code)) {
abort(400, '验证码不符合');
        }

        if (
        !InviteTask::where('id', $request->invite_task_id)
            ->where('enable', 1)
            ->where('start', '<', Carbon::now())
            ->where('end', '>', Carbon::now())
            ->first()
        ) {
            abort(400, '很抱歉，活动已经结束');
        }

        if (!User::find($request->user_id)) {
            abort(400, '不合法的业务员id');
        }
        //保存
        InviteTaskUser::create([
            'user_id' => $request->user_id,
            'invite_task_id' => $request->invite_task_id,
            'phone' => $data['phone'],
        ]);

        Cache::forget($request->verify_key);

        return response()->json([
            'message' => '验证成功，信息已录入'
        ]);
    }
}

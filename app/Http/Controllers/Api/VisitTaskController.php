<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\VisitTaskRequest;
use App\Models\OutTask;
use App\Models\OutTaskUser;
use App\Models\User;
use App\Models\VisitTask;
use App\Models\VisitTaskUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VisitTaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = VisitTask::select(['id', 'title', 'urgency', 'start', 'end', 'enable'])
            ->where('enable', 1)
            ->where('start', '<', Carbon::now())
            ->where('end', '>', Carbon::now())
            ->whereIn('scope_id', [1, $request->user()->scope_id])
            ->orderByDesc('urgency')
            ->orderByDesc('created_at')
            ->paginate(10);
        foreach ($tasks as $task) {
            $task->finish = VisitTaskUser::where('user_id', $request->user()->id)
                ->where('visit_task_id', $task->id)
                ->count();
        }
        return response()->json($tasks);
    }

    public function show(VisitTask $task)
    {
        return response()->json($task);
    }

    public function store(VisitTaskRequest $request)
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
        !VisitTask::where('id', $request->visit_task_id)
            ->where('enable', 1)
            ->where('start', '<', Carbon::now())
            ->where('end', '>', Carbon::now())
            ->first()
        ) {
            abort(400, '很抱歉，活动已经结束');
        }

        //保存
        VisitTaskUser::create([
            'user_id' => $request->user()->id,
            'visit_task_id' => $request->visit_task_id,
            'phone' => $data['phone'],
            'comment' => $request->comment,
            'username' => $request->username
        ]);

        Cache::forget($request->verify_key);

        return response()->json([
            'message' => '验证成功，信息已录入'
        ]);
    }
}

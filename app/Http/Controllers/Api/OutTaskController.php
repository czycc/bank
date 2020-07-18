<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OutTaskRequest;
use App\Models\OutTask;
use App\Models\OutTaskUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OutTaskController extends Controller
{
    public function index()
    {
        $tasks = OutTask::select(['id', 'title', 'urgency', 'start', 'end', 'enable'])
            ->where('enable', 1)
            ->where('start', '<', Carbon::now())
            ->where('end', '>', Carbon::now())
            ->orderByDesc('urgency')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return response()->json($tasks);
    }

    public function show($id)
    {
        $task = OutTask::find($id);

        return response()->json($task);
    }

    /**
     * @param OutTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * 保存客户任务记录
     */
    public function store(OutTaskRequest $request)
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

        if (!User::find($request->user_id)) {
            abort(400, '不合法的业务员id');
        }

        if (
            !OutTask::where('id', $request->out_task_id)
            ->where('enable', 1)
            ->whereDate('start', '<', Carbon::now())
            ->whereDate('end', '>', Carbon::now())
            ->first()
        ) {
            abort(400, '很抱歉，活动已经结束');
        }

        //保存
        OutTaskUser::create([
            'user_id' => $request->user_id,
            'out_task_id' => $request->out_task_id,
            'phone' => $data['phone']
        ]);

        return response()->json([
            'status' => true
        ]);
    }
}

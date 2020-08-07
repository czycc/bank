<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OutTaskRequest;
use App\Models\InviteTaskUser;
use App\Models\OutTask;
use App\Models\OutTaskUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OutTaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = OutTask::select(['id', 'title', 'urgency', 'start', 'end', 'enable'])
            ->where('enable', 1)
            ->where('start', '<', Carbon::now())
            ->where('end', '>', Carbon::now())
            ->whereIn('scope_id', [1, $request->user()->scope_id])
            ->orderByDesc('urgency')
            ->orderByDesc('created_at')
            ->paginate(10);
        foreach ($tasks as $task) {
            $task->finish = OutTaskUser::where('user_id', $request->user()->id)
                ->where('out_task_id', $task->id)
                ->count();
        }
        return response()->json($tasks);
    }

    public function show(OutTask $task)
    {
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

//        if (
//            !OutTask::where('id', $request->out_task_id)
////            ->where('enable', 1)
////            ->where('start', '<', Carbon::now())
////            ->where('end', '>', Carbon::now())
//            ->first()
//        ) {
//            abort(400, '很抱歉，活动已经结束');
//        }

        //保存
        OutTaskUser::create([
            'user_id' => $request->user_id,
            'out_task_id' => $request->out_task_id,
            'phone' => $data['phone']
        ]);

        Cache::forget($request->verify_key);

        return response()->json([
            'message' => '您已经参与成功'
        ]);
    }
}

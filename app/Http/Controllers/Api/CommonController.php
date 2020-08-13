<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UploadImageRequest;
use App\Models\InviteTask;
use App\Models\Material;
use App\Models\NewTask;
use App\Models\Online;
use App\Models\OnlineCategory;
use App\Models\OutTask;
use App\Models\User;
use App\Models\VisitTask;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CommonController extends Controller
{
    /**
     * @param UploadImageRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * 图片统一上传
     */
    public function uploadImage(UploadImageRequest $request)
    {
        $path = $request->file('image')->store('', 'admin');

        return response()->json([
            'path' => asset('upload/' . $path)
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * 系统key
     */
    public function options(Request $request)
    {
        return response()->json([
            'value' => option($request->input('key'))
        ]);
    }

    public function jssdk(Request $request)
    {
        $officialAccount = \EasyWeChat::officialAccount();
        if ($request->url) {
            $officialAccount->jssdk->setUrl($request->url);
        }
        $jssdk = $officialAccount->jssdk->buildConfig(explode(',', $request->apis), false, $beta = false, $json = true);
        return response()->json(json_decode($jssdk, true));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * 首页数据
     */
    public function home(Request $request)
    {
        $data = [];

        $data['out_task'] = OutTask::select(['id', 'title', 'urgency', 'start', 'end', 'enable'])
            ->where('enable', 1)
            ->where('start', '<', Carbon::now())
            ->where('end', '>', Carbon::now())
            ->whereIn('scope_id', [1, $request->user()->scope_id])
            ->orderByDesc('urgency')
            ->orderByDesc('created_at')
            ->first();
        $data['visit_task'] = VisitTask::select(['id', 'title', 'urgency', 'start', 'end', 'enable'])
            ->where('enable', 1)
            ->where('start', '<', Carbon::now())
            ->where('end', '>', Carbon::now())
            ->whereIn('scope_id', [1, $request->user()->scope_id])
            ->orderByDesc('urgency')
            ->orderByDesc('created_at')
            ->first();
        $data['new_task'] = NewTask::select(['id', 'title', 'urgency', 'start', 'end', 'enable'])
            ->where('enable', 1)
            ->where('start', '<', Carbon::now())
            ->where('end', '>', Carbon::now())
            ->whereIn('scope_id', [1, $request->user()->scope_id])
            ->orderByDesc('urgency')
            ->orderByDesc('created_at')
            ->first();
        $data['invite_task'] = InviteTask::select(['id', 'title', 'urgency', 'start', 'end', 'enable'])
            ->where('enable', 1)
            ->where('start', '<', Carbon::now())
            ->where('end', '>', Carbon::now())
            ->whereIn('scope_id', [1, $request->user()->scope_id])
            ->orderByDesc('urgency')
            ->orderByDesc('created_at')
            ->first();

        //获取对应类目下的活动列表
        $data['hots'] = [
            'category_id' => 1,
            'data' => Online::where('category_id', 1)
                ->where('enable', 1)
                ->whereIn('scope_id', [1, $request->user()->scope_id])
                ->whereDate('end', '>', Carbon::now())
                ->orderByDesc('weight')
                ->limit(4)
                ->get()
        ];
        $data['products'] = [
            'category_id' => 2,
            'data' => Online::where('category_id', 2)
                ->where('enable', 1)
                ->whereIn('scope_id', [1, $request->user()->scope_id])
                ->whereDate('end', '>', Carbon::now())
                ->orderByDesc('weight')
                ->limit(4)
                ->get()
        ];
        $data['courses'] = [
            'category_id' => 3,
            'data' => Online::where('category_id', 3)
                ->where('enable', 1)
                ->whereIn('scope_id', [1, $request->user()->scope_id])
                ->whereDate('end', '>', Carbon::now())
                ->orderByDesc('weight')
                ->limit(4)
                ->get()
        ];

        //素材中心
        $data['materials'] = Material::orderByDesc('weight')->limit(6)->get();

        return response()->json(
            $data
        );
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     *
     * 生成分享二维码
     */
    public function qrcode(Request $request)
    {
        $this->validate($request, [
            'text' => 'required|string|between:1,200'
        ]);
        $qrcode = \QrCode::format('png')
            ->encoding('UTF-8')
            ->size('400')
            ->margin(2)
            ->generate($request->text);
        return Image::make($qrcode)->response();

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * 任务用户详情
     */
    public function taskList(Request $request)
    {
        $this->validate($request, [
            'category' => 'required|in:out_task,new_task,visit_task,invite_task',
            'task_id' => 'required',
        ]);
        $category = $request->category;
        $task_id = $request->task_id;
        if ($category == 'out_task') {
            //查询用户
            $model = new OutTask();
        } elseif ($category == 'new_task') {
            $model = new NewTask();
        } elseif ($category == 'visit_task') {
            $model = new VisitTask();
        } else {
            $model = new InviteTask();
        }

        $items = $model->select(DB::raw('count(*) as scount,user_id,task_id'))
            ->where('task_id', $task_id)
            ->groupBy('user_id')
            ->orderByDesc('scount')
            ->limit(5)
            ->get();
        foreach ($items as $item) {
            $item->name = $item->user()->name;
        }

        $tasks = $model::where('user_id', $request->user()->id)
            ->where('task_id', $request->task_id)
            ->orderByDesc('id')
            ->paginate(20);

        return response()->json([
            'rank' => $items,
            'tasks' => $tasks
        ]);
    }
}

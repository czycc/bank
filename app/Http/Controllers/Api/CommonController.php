<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UploadImageRequest;
use App\Models\Material;
use App\Models\Online;
use App\Models\OnlineCategory;
use App\Models\OutTask;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
    public function home()
    {
        $data = [];

        $out_task = OutTask::select(['id', 'title', 'urgency', 'start', 'end', 'enable'])
            ->where('enable', 1)
            ->where('start', '<', Carbon::now())
            ->where('end', '>', Carbon::now())
            ->orderByDesc('urgency')
            ->orderByDesc('created_at')
            ->first();
        $data['tasks'] = [
//            [
//                'category_id' => 1,
//                'id' => $out_task->id,
//                'title' => $out_task->title,
//                'urgency' => $out_task->urgency,
//                'end' => $out_task->end
//            ],
            [
                'category_id' => 2,
                'id' => $out_task->id,
                'title' => '来访任务',
                'urgency' => 1,
                'end' => Carbon::now()->toDateString()
            ], [
                'category_id' => 3,
                'title' => '老带新任务',
                'urgency' => 0,
                'end' => Carbon::now()->toDateString()
            ], [
                'category_id' => 4,
                'title' => '邀约任务',
                'urgency' => 1,
                'end' => Carbon::now()->toDateString()
            ],
        ];

        //获取对应类目下的活动列表
        $data['hots'] = [
            'category_id' => 1,
            'data' => Online::where('category_id', 1)
                ->where('enable', 1)
                ->whereDate('end', '>', Carbon::now())
                ->orderByDesc('weight')
                ->limit(3)
                ->get()
        ];
        $data['products'] = [
            'category_id' => 2,
            'data' => Online::where('category_id', 2)
                ->where('enable', 1)
                ->whereDate('end', '>', Carbon::now())
                ->orderByDesc('weight')
                ->limit(3)
                ->get()
        ];
        $data['courses'] = [
            'category_id' => 3,
            'data' => Online::where('category_id', 3)
                ->where('enable', 1)
                ->whereDate('end', '>', Carbon::now())
                ->orderByDesc('weight')
                ->limit(3)
                ->get()
        ];

        //素材中心
        $data['materials'] = Material::orderByDesc('weight')->limit(6)->get();

        return response()->json(
            $data
        );
    }

    public function qrcode(Request $request)
    {
        $this->validate($request, [
            'text' => 'required|string|between:1,200'
        ]);

        return \QrCode::encoding('UTF-8')->format('png')->generate('test');

    }
}

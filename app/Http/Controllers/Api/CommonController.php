<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UploadImageRequest;
use App\Models\Material;
use App\Models\Online;
use App\Models\OnlineCategory;
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

        $data['tasks'] = [
            [
                'id' => 1,
                'category' => '外拓任务',
                'urgent' => 0,
                'date' => '2020=06-22'
            ],[
                'id' => 2,
                'category' => '来访任务',
                'urgent' => 1,
                'date' => '2020=06-22'
            ],[
                'id' => 3,
                'category' => '老带新任务',
                'urgent' => 0,
                'date' => '2020=06-22'
            ], [
                'id' => 4,
                'category' => '邀约任务',
                'urgent' => 1,
                'date' => '2020=06-22'
            ],
        ];

        //获取对应类目下的活动列表
        $categories = OnlineCategory::all();
        foreach ($categories as $category) {
            $data['onlines'][] = [
                'id' => $category->id,
                'name' => $category->name,
                'data' => Online::where('category_id', $category->id)
                    ->where('enable', 1)
                    ->whereDate('end', '>', Carbon::now())
                    ->orderByDesc('weight')
                    ->limit(3)
                    ->get()
            ];
        }

        //素材中心
        $data['materials'] = Material::orderByDesc('weight')->limit(6)->get();

        return response()->json(
            $data
        );
    }
}

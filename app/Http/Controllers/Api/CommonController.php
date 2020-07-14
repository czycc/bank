<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UploadImageRequest;
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
        $jssdk = $officialAccount->jssdk->buildConfig(explode(',',$request->apis), false, $beta = false, $json = true);
        return response()->json(json_decode($jssdk, true));
    }
}

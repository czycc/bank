<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DrawItemRequest;
use App\Models\Draw;
use App\Models\DrawItem;
use App\Models\DrawItemUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DrawController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * 返回抽奖列表
     */
    public function index(Request $request)
    {
        $items = Draw::select(['id', 'title'])->where('enable', 1)->paginate(10);

        return response()->json($items);
    }

    /**
     * @param Draw $draw
     * @return \Illuminate\Http\JsonResponse
     * 显示抽奖活动
     */
    public function show(Draw $draw)
    {
        $draw->items = $draw->items;

        return response()->json($draw);
    }

    public function drawItem(Request $request)
    {
        $data = Cache::get($request->draw_key);
        if (!$data) {
            abort(400, '您的验证已失效，请重新发送验证码');
        }

        $draw = Draw::find($data['draw_id']);

        $a[] = 0;

        foreach ($draw->items as $item) {
            $a[] = $item->id;
        }

        $draw_item_id = array_rand($a);

        $i = DrawItemUser::create([
            'phone' => $data['phone'],
            'user_id' => $data['user_id'],
            'draw_item_id' => $draw_item_id,
            'draw_id' => $data['draw_id']
        ]);

        return response()->json($i);
    }

    public function store(DrawItemRequest $request)
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
        !$item = Draw::where('id', $request->draw_id)
            ->where('enable', 1)
            ->first()
        ) {
            abort(400, '抽奖活动已结束');
        }

        if (!User::find($request->user_id)) {
            abort(400, '不合法的业务员id');
        }
        //保存
        $key = 'draw_'.\Str::random(15);
        $expiredAt = now()->addMinutes(30);
        \Cache::put($key, [
            'phone' => $data['phone'],
            'user_id' => $request->user_id,
            'draw_id' => $request->draw_id
        ], $expiredAt);

        Cache::forget($request->verify_key);

        return response()->json([
            'message' => '验证成功，请进行抽奖',
            'draw_key' => $key
        ]);
    }
}

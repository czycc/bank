<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DrawItemRequest;
use App\Models\Draw;
use App\Models\DrawItem;
use App\Models\DrawItemUser;
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

    public function drawItem(Draw $draw)
    {
        $items = $draw->items;

        $ids[] = 0;

        foreach ($items as $item) {
            $ids[] = $item->id;
        }

        $a = array_rand($ids);

        return response()->json([
            'id' => $a
        ]);
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

        if ($request->draw_item_id == 0) {
            return response()->json([
                'message' => '验证成功，很遗憾你未中奖'
            ]);
        }

        if (
        !$item = DrawItem::where('id', $request->draw_item_id)
            ->first()
        ) {
            abort(400, '奖品不存在');
        }

        if (!User::find($request->user_id)) {
            abort(400, '不合法的业务员id');
        }
        //保存
        DrawItemUser::create([
            'user_id' => $request->user_id,
            'draw_item_id' => $request->draw_item_id,
            'draw_id' => $item->draw_id,
            'phone' => $data['phone'],
        ]);

//        Cache::forget($request->verify_key);

        return response()->json([
            'message' => '验证成功，奖品信息已录入'
        ]);
    }
}

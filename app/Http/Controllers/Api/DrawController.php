<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Draw;
use Illuminate\Http\Request;

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
        $draw->draw_items = $draw->items;

        return response()->json($draw);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DrawItemRequest;
use App\Models\Draw;
use App\Models\DrawItem;
use App\Models\DrawItemUser;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
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
        $num = DrawItemUser::where('phone', $data['phone'])
            ->where('draw_id', $draw->id)
            ->count();

        if ($num >= $draw->num) {
            abort(400, '很抱歉,您的抽奖次数已用完');
        }

        foreach ($draw->items as $item) {
            if ($item->stock > 0 && $item->odds > 0) {
                $a[] = $item->id;
            }
        }

        $draw_item_id = array_rand($a);

        $i = DrawItemUser::create([
            'phone' => $data['phone'],
            'user_id' => $data['user_id'],
            'draw_item_id' => $draw_item_id,
            'draw_id' => $draw->id
        ]);


        unset($a);

        //减少库存
        if ($draw_item_id) {
            $item = DrawItem::find($draw_item_id);

            $msg = '000071000220200919000000014169'.
                mb_convert_encoding(str_pad(mb_convert_encoding($item->reward, 'gb2312', 'utf-8'), 20), 'utf-8', 'gb2312')
                . $data['phone'] .'         1';
            //发送中奖信息
            $client = new Client([
                'timeout' => 10.0,
                'base_uri' => 'http://112.81.84.7:8000'
            ]);
            $client->request('POST', 'api/v1/common/sms/send', [
                'json' => [
                    'msg' => $msg,
                    'category' => 'draw'
                ]
            ]);

            $item->stock -= 1;
            $item->out += 1;
            $item->save();
        }

        return response()->json($i);
    }

    public function store(DrawItemRequest $request)
    {
        //获取验证码
        $data = Cache::get($request->verify_key);

        if (!$data) {
            abort(400, '验证码已过期，请重新发送');
        }

        if (!confirmSms($request->phone, $request->verify_code)) {
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

    public function verifyList(Request $request)
    {
        $items = DrawItemUser::where('phone', $request->phone)
            ->where('draw_item_id', '!=', 0)
            ->orderBy('verify')
            ->limit(10)
            ->get();
        foreach ($items as $item) {
            $item->reward = DrawItem::find($item->draw_item_id)->reward;
            if ($item->draw) {
                $item->draw_title = $item->draw->title;
            } else {
                unset($item);
            }
        }

        return response()->json($items);
    }

    public function verifyStore(Request $request)
    {
        //获取验证码
        $data = Cache::get($request->verify_key);

        if (!$data) {
            abort(400, '验证码已过期，请重新发送');
        }

        if (!confirmSms($request->phone, $request->verify_code)) {
            // 返回401
            abort(400, '验证码不符合');
        }

        $v = DrawItemUser::find($request->draw_item_user_id);
        if ($v->phone !== $data['phone']) {
            abort(400, '手机号不对呀');
        }
        $v->verify = 1;
        $v->verify_user_id = $request->user()->id;
        $v->save();

        return response()->json([
            'message' => '核销成功'
        ]);
    }
}

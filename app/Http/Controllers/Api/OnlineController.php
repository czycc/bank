<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OnlineRequest;
use App\Models\Online;
use App\Models\OnlineUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OnlineController extends Controller
{
    public function index(Request $request)
    {
        $category_id = $request->category_id;

        $data = Online::select(['id', 'title', 'banner', 'end'])
            ->where('category_id', $category_id)
            ->where('enable', 1)
            ->whereIn('scope_id', [1, $request->user()->scope_id])
            ->whereDate('end', '>', Carbon::now())
            ->orderByDesc('weight')
            ->paginate(20);
        if ($request->user()) {
            foreach ($data as $item) {
                $item->visit = visits($item, $item->id . '_' . $request->user()->id)->count();
            }
        }

        return response()->json($data);
    }

    public function show($id)
    {
        $online = Online::find($id);

        return response()->json($online);
    }

    public function share(User $user, Online $online)
    {
//        visits($online, $online->id.'_'.$user->id)->increment();
//        visits($online)->increment();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'unit' => $user->unit,
                'avatar' => $user->avatar
            ],
            'online' => $online,
            'is_open' => $online->end < Carbon::now()
        ]);
    }

    public function shareToOther(Request $request)
    {
        $path = $request->get('path');
        $user_id = $request->get('user_id');
        $online_id = $request->get('online_id');
        $online = Online::find($online_id);

        visits($online, $online_id . '_' . $user_id)->increment();
        visits($online)->increment();
        return redirect($path);
    }

    public function store(OnlineRequest $request)
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
        !Online::where('id', $request->online_id)
            ->where('enable', 1)
            ->where('end', '>', Carbon::now())
            ->first()
        ) {
            abort(400, '很抱歉，活动已经结束');
        }

        if (!User::find($request->user_id)) {
            abort(400, '不合法的业务员id');
        }
        //保存
        OnlineUser::create([
            'user_id' => $request->user_id,
            'online_id' => $request->online_id,
            'phone' => $data['phone'],
        ]);

        Cache::forget($request->verify_key);

        return response()->json([
            'message' => '验证成功，信息已录入'
        ]);
    }
}

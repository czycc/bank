<?php

namespace App\Http\Controllers\Becks;

use App\Models\BecksRank;
use App\Models\BecksUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BecksController extends Controller
{
    public function rank(Request $request)
    {
        $data = json_decode($request->data);
        $location = $request->location;
        foreach ($data as $item) {
            BecksRank::create([
                'location' => $location,
                'openid' => $item->openid,
                'nickname' => $item->nickname,
                'avatar' => $item->avatar,
                'rank' => $item->rank,
            ]);
        }

        return 'true';
    }

    public function draw(Request $request)
    {
        $wechat = session('wechat.oauth_user.default');
        if ($user = BecksUser::where('openid', $wechat['id'])->first()) {
            $item = $user->item;
            return view('lottery', compact('item'));
        }
        $items = [1, 3, 4,  6, 7];
        $item = array_rand($items);

        BecksUser::create([
            'openid' => $wechat['id'],
            'nickname' => $wechat['name'],
            'avatar' => $wechat['avatar'],
            'item' => $item
        ]);


        return view('lottery', compact('item'));
    }
}

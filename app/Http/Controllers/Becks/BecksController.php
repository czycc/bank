<?php

namespace App\Http\Controllers\Becks;

use App\Models\BecksRank;
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
        $items = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        $item = array_rand($items);

        return view('lottery', compact('item'));
    }
}

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
}

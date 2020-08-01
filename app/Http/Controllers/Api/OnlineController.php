<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Online;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OnlineController extends Controller
{
    public function index(Request $request)
    {
        $category_id = $request->category_id;

        $data = Online::select(['id', 'title', 'banner', 'end'])
            ->where('category_id', $category_id)
            ->where('enable', 1)
            ->whereDate('end', '>', Carbon::now())
            ->orderByDesc('weight')
            ->paginate(20);
        if ($request->user()) {
            foreach ($data as $item) {
                $item->visit = visits($item, $item->id . '_' . $request->user()->id);
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
        $online_id =  $request->get('online_id');
        $online = Online::find($online_id);

        visits($online, $online_id.'_'.$user_id)->increment();

        return redirect($path);
    }
}

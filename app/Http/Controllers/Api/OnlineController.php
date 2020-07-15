<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Online;
use Illuminate\Http\Request;

class OnlineController extends Controller
{
    public function index(Request $request)
    {
        $category_id = $request->category_id;

        $data = Online::where('category_id', $category_id)
            ->orderByDesc('weight')
            ->paginate(10);
    }
}

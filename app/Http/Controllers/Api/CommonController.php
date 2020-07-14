<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UploadImageRequest;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function uploadImage(UploadImageRequest $request)
    {
        $path = $request->file('image')->store('', 'admin');

        return response()->json([
            'path' => asset('upload/' . $path)
        ]);
    }


    public function options(Request $request)
    {
        return response()->json([
            'value' => option($request->input('key'))
        ]);
    }
}

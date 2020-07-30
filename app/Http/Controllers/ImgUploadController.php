<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImgUploadController extends Controller
{
    public function upload(Request $request)
    {
        $img = $request->file('upload');
        $date = date('Ym/d', time());
        $path = Storage::putFile('editor/images/' . $date, $img);


        $param = [
            'uploaded' => 1,
            'fileName' => $path,
            'url' => Storage::url($path)
        ];
        return response()->json($param, 200);
    }
}

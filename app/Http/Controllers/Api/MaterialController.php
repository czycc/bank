<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $materials = Material::select(['id','title','img_url'])
            ->where('enable',0)
            ->orderByDesc('weight')
            ->paginate(15);

        return response()->json($materials);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OutTask;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OutTaskController extends Controller
{
    public function index()
    {
        $tasks = OutTask::select(['id', 'title', 'urgency', 'start', 'end', 'enable'])
            ->where('enable', 1)
            ->whereDate('start', '<', Carbon::now())
            ->whereDate('end', '>', Carbon::now())
            ->orderByDesc('urgency')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return response()->json($tasks);
    }

    public function show($id)
    {
        $task = OutTask::find($id);

        return response()->json($task);
    }
}

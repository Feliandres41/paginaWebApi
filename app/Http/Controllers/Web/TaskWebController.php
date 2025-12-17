<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TaskWebController extends Controller
{
    public function store(Request $request, $projectId)
    {
        Http::withToken(session('api_token'))
            ->post("http://127.0.0.1:8000/api/projects/$projectId/tasks", [
                'title' => $request->title
            ]);

        return back();
    }

    public function toggle($projectId, $taskId)
    {
        Http::withToken(session('api_token'))
            ->patch("http://127.0.0.1:8000/api/projects/$projectId/tasks/$taskId/toggle");

        return back();
    }
}

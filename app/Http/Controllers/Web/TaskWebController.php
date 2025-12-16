<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TaskWebController extends Controller
{
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'title' => 'required|string'
        ]);

        Http::withToken(session('api_token'))
            ->post("http://127.0.0.1:8000/api/projects/$projectId/tasks", [
                'title' => $request->title
            ]);

        return back();
    }


    public function complete($id)
    {
        Http::withToken(session('api_token'))
            ->put(config('services.api.url')."/tasks/$id/complete");

        return back();
    }
    public function toggle($taskId)
    {
        $token = session('api_token');

        Http::withToken($token)
            ->patch(config('services.api.url') . "/tasks/{$taskId}/toggle");

        return back();
    }
}

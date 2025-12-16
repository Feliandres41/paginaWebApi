<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TaskWebController extends Controller
{
    public function store(Request $request)
    {
        Http::withToken(session('api_token'))
            ->post(config('services.api.url').'/tasks', [
                'project_id' => $request->project_id,
                'title' => $request->title,
                'due_date' => $request->due_date
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

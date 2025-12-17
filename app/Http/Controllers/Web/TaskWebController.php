<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TaskWebController extends Controller
{
    public function toggle($projectId, $taskId)
    {
        $token = session('api_token');

        if (!$token) {
            return redirect()->route('login.form');
        }

        // 🔗 LLAMADA A LA API (NO MODELOS)
        $response = Http::withToken($token)->patch(
            "http://127.0.0.1:8000/api/projects/$projectId/tasks/$taskId/toggle"
        );

        if ($response->failed()) {
            return back()->with('error', 'No se pudo actualizar la tarea');
        }

        return back(); 
    }
}

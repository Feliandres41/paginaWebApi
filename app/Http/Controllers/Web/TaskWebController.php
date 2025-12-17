<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TaskWebController extends Controller
{
    /**
     * Crear una nueva tarea (consume la API)
     */
    public function store(Request $request, $projectId)
    {
        $token = session('api_token');

        if (!$token) {
            return redirect()->route('login');
        }

        $response = Http::withToken($token)
            ->post("http://127.0.0.1:8000/api/projects/{$projectId}/tasks", [
                'title' => $request->title,
            ]);

        if ($response->failed()) {
            return back()->with('error', 'No se pudo crear la tarea');
        }

        return back(); // 🔄 vuelve al proyecto y ya debe verse la tarea
    }

    /**
     * Cambiar estado completo / incompleto
     */
    public function toggle($projectId, $taskId)
    {
        $token = session('api_token');

        if (!$token) {
            return redirect()->route('login');
        }

        $response = Http::withToken($token)
            ->patch("http://127.0.0.1:8000/api/projects/{$projectId}/tasks/{$taskId}/toggle");

        if ($response->failed()) {
            return back()->with('error', 'No se pudo actualizar la tarea');
        }

        return back();
    }
}

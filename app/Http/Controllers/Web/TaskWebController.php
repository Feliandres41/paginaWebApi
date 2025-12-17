<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TaskWebController extends Controller
{
    /**
     * Crear una tarea (consume la API)
     */
    public function store(Request $request, $projectId)
    {
        $token = session('api_token');

        if (!$token) {
            return redirect()->route('login');
        }

        $response = Http::withToken($token)->post(
            config('services.api.url') . '/tasks',
            [
                'project_id' => $projectId,
                'title' => $request->title,
                'due_date' => null
            ]
        );

        if ($response->failed()) {
            return back()->with('error', 'No se pudo crear la tarea');
        }

        return back();
    }

    /**
     * 🔁 CAMBIAR estado de la tarea (completo / incompleto)
     */
    public function toggle($projectId, $taskId)
    {
        $token = session('api_token');

        if (!$token) {
            return redirect()->route('login');
        }

        // 👇 ESTE ES EL ENDPOINT REAL DE LA API
        $response = Http::withToken($token)->patch(
            config('services.api.url') . "/projects/$projectId/tasks/$taskId/toggle"
        );

        if ($response->failed()) {
            return back()->with('error', 'No se pudo actualizar la tarea');
        }

        return back();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'title'      => 'required|string|max:255',
        ]);

        $token = session('api_token');

        Http::withToken($token)
            ->post(env('API_URL') . '/tasks', [
                'project_id' => $request->project_id,
                'title'      => $request->title,
            ]);

        return redirect()->route('dashboard');
    }

    public function complete(Request $request, $id)
    {
        $token = session('api_token');

        Http::withToken($token)
            ->put(env('API_URL') . "/tasks/{$id}/complete");

        return redirect()->route('dashboard');
    }
}

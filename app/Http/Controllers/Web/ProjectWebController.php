<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProjectWebController extends Controller
{
    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        Http::withToken(session('api_token'))
            ->post('http://127.0.0.1:8000/api/projects', [
                'name' => $request->name,
                'description' => $request->description,
            ]);

        return redirect()->route('dashboard');
    }

    public function show($id)
    {
        $response = Http::withToken(session('api_token'))
            ->get("http://127.0.0.1:8000/api/projects/$id");

        $project = $response->json();

        return view('projects.show', compact('project'));
    }

    public function destroy($id)
    {
        Http::withToken(session('api_token'))
            ->delete("http://127.0.0.1:8000/api/projects/$id");

        return redirect()->route('dashboard');
    }
}

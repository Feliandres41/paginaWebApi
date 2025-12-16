<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProjectController extends Controller
{
    public function dashboard(Request $request)
    {
        $token = session('api_token');

        $response = Http::withToken($token)
            ->get(env('API_URL') . '/projects');

        $body = $response->json();

        $projects = [];
        $message = '';

        if (isset($body['data'])) {
            $projects = $body['data'];
        } elseif ($response->ok() && empty($body)) {
            $projects = [];
        } elseif (isset($body['message'])) {
            $message = $body['message'];
        }

        return view('dashboard', [
            'projects' => $projects,
            'message' => $message,
            'user' => session('user')
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);

        $token = session('api_token');

        Http::withToken($token)
            ->post(env('API_URL') . '/projects', [
                'name' => $request->name,
            ]);

        return redirect()->route('dashboard');
    }
}

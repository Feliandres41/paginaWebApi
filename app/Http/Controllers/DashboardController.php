<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected ApiService $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        $token = session('api_token');

        $response = Http::withToken($token)
            ->get(config('services.api.url') . '/projects');

        if ($response->failed()) {
            return redirect()->route('login');
        }

        $projects = collect($response->json()); // 👈 AQUÍ LA SOLUCIÓN

        return view('dashboard.index', compact('projects'));
    }
}
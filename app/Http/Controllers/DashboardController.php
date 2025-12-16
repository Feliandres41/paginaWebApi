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
        $response = $this->apiService->getAllProjects();

        if (!$response['success']) {
            return view('dashboard.index')->with('error', 'No se pudo conectar con la API');
        }

        $projects = $response['data']['data'] ?? $response['data'] ?? [];

        // Calcular estadísticas
        $stats = [
            'total_projects' => count($projects),
            'active_projects' => count(array_filter($projects, fn($p) => !($p['is_archived'] ?? false))),
            'archived_projects' => count(array_filter($projects, fn($p) => $p['is_archived'] ?? false)),
        ];

        return view('dashboard.index', compact('projects', 'stats'));
    }
}
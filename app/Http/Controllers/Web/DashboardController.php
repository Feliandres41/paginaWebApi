<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $token = session('api_token');

        $response = Http::withToken($token)
            ->get(config('services.api.url') . '/projects');

        if ($response->failed()) {
            return redirect()->route('login');
        }

        // 👇 ESTO ES CLAVE
        $projects = collect($response->json());

        return view('dashboard.index', compact('projects'));
    }
}

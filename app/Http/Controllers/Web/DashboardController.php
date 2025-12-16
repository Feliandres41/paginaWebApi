<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

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

        $projects = $response->json();

        return view('dashboard.index', compact('projects'));
    }
}

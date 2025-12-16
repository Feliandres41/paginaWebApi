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
            ->post(config('services.api.url').'/projects', [
                'name' => $request->name,
                'description' => $request->description,
                'is_archived' => 0
            ]);

        return redirect()->route('dashboard');
    }

    public function show($id)
    {
        $project = Http::withToken(session('api_token'))
            ->get(config('services.api.url')."/projects/$id")
            ->json();

        return view('projects.show', compact('project'));
    }

    public function destroy($id)
    {
        Http::withToken(session('api_token'))
            ->delete(config('services.api.url')."/projects/$id");

        return redirect()->route('dashboard');
    }
}

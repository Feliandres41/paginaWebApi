<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $response = Http::post(env('API_URL') . '/login', $data);

        if ($response->failed()) {
            return back()->withErrors(['email' => 'Credenciales inválidas']);
        }

        $body = $response->json();
        session(['api_token' => $body['token'], 'user' => $body['user']]);

        return redirect()->route('dashboard');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('login')->with('success', 'Cuenta creada');
    }

    public function logout(Request $request)
    {
        $token = session('api_token');

        Http::withToken($token)->post(env('API_URL') . '/logout');

        $request->session()->flush();

        return redirect()->route('login');
    }
}

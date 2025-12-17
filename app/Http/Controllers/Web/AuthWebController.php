<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthWebController extends Controller
{
    // 🔐 FORMULARIO LOGIN
    public function showLogin()
    {
        return view('auth.login');
    }

    // 📝 FORMULARIO REGISTRO  ✅ ESTE FALTABA
    public function showRegister()
    {
        return view('auth.register');
    }

    // 🔑 PROCESAR LOGIN (API)
    public function login(Request $request)
    {
        $response = Http::post('http://127.0.0.1:8000/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->failed()) {
            return back()->withErrors([
                'email' => 'Credenciales incorrectas'
            ]);
        }

        // ✅ guardar token de la API
        session(['api_token' => $response['token']]);

        return redirect()->route('dashboard');
    }

    // 📝 PROCESAR REGISTRO (API)
    public function register(Request $request)
    {
        $response = Http::post('http://127.0.0.1:8000/api/register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        if ($response->failed()) {
            return back()->withErrors($response->json());
        }

        return redirect()->route('login');
    }

    // 🚪 LOGOUT
    public function logout()
    {
        session()->forget('api_token');
        return redirect()->route('login');
    }
}

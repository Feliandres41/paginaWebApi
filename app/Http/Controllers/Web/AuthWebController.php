<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthWebController extends Controller
{
    /* =========================
       LOGIN
    ========================= */

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Login contra la API
        $response = Http::post('http://127.0.0.1:8000/api/login', [
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        if ($response->failed()) {
            return back()->withErrors([
                'email' => 'Credenciales incorrectas'
            ]);
        }

        $data = $response->json();

        // Guardar token y usuario en sesión
        session([
            'api_token' => $data['token'],
            'user'      => $data['user'],
        ]);

        // Autenticar usuario en la web
        Auth::loginUsingId($data['user']['id']);

        return redirect()->route('dashboard');
    }

    /* =========================
       REGISTER
    ========================= */

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email',
            'password'              => 'required|min:6|confirmed',
        ]);

        // Enviar datos a la API
        $response = Http::post('http://127.0.0.1:8000/api/register', [
            'name'                  => $request->name,
            'email'                 => $request->email,
            'password'              => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        if ($response->failed()) {
            return back()->withErrors($response->json());
        }

        return redirect()->route('login')
            ->with('success', 'Cuenta creada correctamente');
    }

    /* =========================
       LOGOUT
    ========================= */

    public function logout(Request $request)
    {
        if (session('api_token')) {
            Http::withToken(session('api_token'))
                ->post('http://127.0.0.1:8000/api/logout');
        }

        session()->forget(['api_token', 'user']);
        Auth::logout();

        return redirect()->route('login');
    }
}

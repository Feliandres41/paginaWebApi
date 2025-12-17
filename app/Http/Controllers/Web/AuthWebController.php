<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthWebController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

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

        session(['api_token' => $response['token']]);

        $user = User::where('email', $request->email)->first();

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function register(Request $request)
    {
        $response = Http::post('http://127.0.0.1:8000/api/register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        if ($response->failed()) {
            return back()->withErrors(['email' => 'No se pudo registrar']);
        }

        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::logout();
        session()->forget('api_token');

        return redirect()->route('login');
    }
}

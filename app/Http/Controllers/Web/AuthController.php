<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    // FORMULARIO
    public function showRegister()
    {
        return view('auth.register');
    }

    // PROCESAR REGISTRO
    public function register(Request $request)
    {
        $response = Http::post('http://127.0.0.1:8000/api/register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        if ($response->successful()) {
            return redirect('/login')->with('success', 'Cuenta creada correctamente');
        }

        return back()->withErrors($response->json());
    }
}

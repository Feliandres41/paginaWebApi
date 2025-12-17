<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Iniciar sesión
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Validar las credenciales
        if (Auth::attempt($credentials)) {
            // Autenticación exitosa, obtener el usuario
            $user = Auth::user();

            // Generar el token (si usas API Token)
            $token = $user->createToken('MyApp')->plainTextToken;

            // Guardar el token en la sesión o devolverlo al frontend
            session(['api_token' => $token]);

            // Redirigir al dashboard
            return redirect()->route('dashboard');
        }

        // Si las credenciales no son correctas
        return back()->withErrors(['email' => 'Las credenciales son incorrectas']);
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // Mostrar formulario de registro
    public function showRegister()
    {
        return view('auth.register');
    }

    // Procesar registro
    public function register(Request $request)
    {
        // Validar los datos de registro
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('register.get')
                ->withErrors($validator)
                ->withInput();
        }

        // Crear un nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Iniciar sesión automáticamente al registrar
        Auth::login($user);

        // Redirigir al dashboard
        return redirect()->route('dashboard');
    }
}

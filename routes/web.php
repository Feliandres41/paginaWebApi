<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

// Página inicio
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Mostrar formulario registro
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// PROCESAR REGISTRO (🔥 ESTA ES LA QUE FALTABA 🔥)
Route::post('/register', [AuthController::class, 'register'])
    ->name('register.post');

// Mostrar formulario login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Procesar login
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

/*
|--------------------------------------------------------------------------
| Rutas protegidas
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});

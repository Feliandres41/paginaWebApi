<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\DashboardController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (WEB)
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', function () {
    return redirect()->route('login');
});

// Login
Route::get('/login', [AuthWebController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthWebController::class, 'login'])
    ->name('login.post');

// Register
Route::get('/register', [AuthWebController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthWebController::class, 'register'])
    ->name('register.post');

// Logout
Route::post('/logout', [AuthWebController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (WEB)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

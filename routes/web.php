<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProjectWebController;
use App\Http\Controllers\Web\TaskWebController;

/*
|--------------------------------------------------------------------------
| RUTA INICIAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN (WEB)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthWebController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthWebController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [AuthWebController::class, 'logout'])
    ->name('logout');

Route::get('/register', [AuthWebController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthWebController::class, 'register'])
    ->name('register.post');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PROYECTOS
    |--------------------------------------------------------------------------
    */
    Route::get('/projects/create', [ProjectWebController::class, 'create'])
        ->name('projects.create');

    Route::post('/projects', [ProjectWebController::class, 'store'])
        ->name('projects.store');

    Route::get('/projects/{project}', [ProjectWebController::class, 'show'])
        ->name('projects.show');

    Route::delete('/projects/{project}', [ProjectWebController::class, 'destroy'])
        ->name('projects.destroy');

    /*
    |--------------------------------------------------------------------------
    | TAREAS (DEPENDEN DEL PROYECTO)
    |--------------------------------------------------------------------------
    */
    Route::post(
        '/projects/{project}/tasks',
        [TaskWebController::class, 'store']
    )->name('tasks.store');

    Route::patch(
        '/projects/{project}/tasks/{task}/toggle',
        [TaskWebController::class, 'toggle']
    )->name('tasks.toggle');
});

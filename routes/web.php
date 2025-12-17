<?php
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProjectWebController;
use App\Http\Controllers\Web\TaskWebController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('auth.login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas de registro (Asegúrate de que estas rutas estén definidas correctamente)
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.get');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Protegidas
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Proyectos
    Route::get('/projects/create', [ProjectWebController::class, 'create'])
        ->name('projects.create');

    Route::post('/projects', [ProjectWebController::class, 'store'])
        ->name('projects.store');

    Route::get('/projects/{id}', [ProjectWebController::class, 'show'])->name('projects.show');


    Route::delete('/projects/{id}', [ProjectWebController::class, 'destroy'])
        ->name('projects.destroy');

    // Tareas
    Route::post('/tasks', [TaskWebController::class, 'store'])
        ->name('tasks.store');

    Route::put('/tasks/{id}/complete', [TaskWebController::class, 'complete'])
        ->name('tasks.complete');

    Route::patch('/tasks/{task}/toggle', [TaskWebController::class, 'toggle'])
    ->name('tasks.toggle');

    Route::post('/projects/{project}/tasks', [TaskWebController::class, 'store'])
    ->name('tasks.store');
    Route::patch('/projects/{project}/tasks/{task}/toggle', [TaskWebController::class, 'toggle'])
    ->name('tasks.toggle');
    
    Route::post('/projects/{project}/tasks', [TaskWebController::class, 'store'])
    ->name('tasks.store');

    Route::patch(
    '/projects/{project}/tasks/{task}/toggle',
    [TaskWebController::class, 'toggle']
    )->name('tasks.toggle');

});

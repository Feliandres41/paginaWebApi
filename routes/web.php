<?php
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProjectWebController;
use App\Http\Controllers\Web\TaskWebController;

// Auth
Route::get('/login', [AuthWebController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login']);
Route::get('/register', [AuthWebController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthWebController::class, 'register']);
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

// Protegidas
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Proyectos
    Route::get('/projects/create', [ProjectWebController::class, 'create'])
        ->name('projects.create');

    Route::post('/projects', [ProjectWebController::class, 'store'])
        ->name('projects.store');

    Route::get('/projects/{id}', [ProjectWebController::class, 'show'])
        ->name('projects.show');

    Route::delete('/projects/{id}', [ProjectWebController::class, 'destroy'])
        ->name('projects.destroy');

    // Tareas
    Route::post('/tasks', [TaskWebController::class, 'store'])
        ->name('tasks.store');

    Route::put('/tasks/{id}/complete', [TaskWebController::class, 'complete'])
        ->name('tasks.complete');

    Route::patch('/tasks/{task}/toggle', [TaskWebController::class, 'toggle'])
    ->name('tasks.toggle');
});

<?php
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProjectWebController;
use App\Http\Controllers\Web\TaskWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthWebController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login'])->name('login.post');

Route::get('/register', [AuthWebController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthWebController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/projects', [ProjectWebController::class, 'store'])
        ->name('projects.store');

    Route::get('/projects/create', [ProjectWebController::class, 'create'])
        ->name('projects.create');

    Route::get('/projects/{id}', [ProjectWebController::class, 'show'])
        ->name('projects.show');

    Route::delete('/projects/{id}', [ProjectWebController::class, 'destroy'])
        ->name('projects.destroy');

    Route::post('/projects/{project}/tasks', [TaskWebController::class, 'store'])
        ->name('tasks.store');

    Route::patch('/projects/{project}/tasks/{task}/toggle', [TaskWebController::class, 'toggle'])
        ->name('tasks.toggle');
});

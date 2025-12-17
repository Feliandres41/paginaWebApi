@extends('layouts.app')

@section('title', 'Proyecto')

@section('content')

<style>
    .task {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px;
        border-bottom: 1px solid #ddd;
    }

    .task.done .task-title {
        text-decoration: line-through;
        color: #777;
    }

    .check-btn {
        border: none;
        background: none;
        font-size: 18px;
        cursor: pointer;
    }

    .back-btn {
        display: inline-block;
        margin-top: 20px;
    }
</style>

<h2>{{ $project['name'] }}</h2>

<form method="POST" action="{{ route('tasks.store', $project['id']) }}">
    @csrf
    <input type="text" name="title" placeholder="Nueva tarea" required>
    <button type="submit">Agregar</button>
</form>

<hr>

<a href="{{ route('dashboard') }}">Volver al menu principal</a>

<h3>Tareas</h3>

@if(empty($project['tasks']))
    <p>No hay tareas</p>
@else
    @foreach($project['tasks'] as $task)
        <div class="task {{ $task['is_completed'] ? 'done' : '' }}">
            <form method="POST"
                  action="{{ route('tasks.toggle', [$project['id'], $task['id']]) }}">
                @csrf
                @method('PATCH')

                <button>
                    {{ $task['is_completed'] ? '🟢 Completa' : '⭕ Pendiente' }}
                </button>
            </form>

            <span>{{ $task['title'] }}</span>
        </div>
    @endforeach
@endif
@endsection
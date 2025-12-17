<h3>Nueva tarea</h3>
<style>
    .task {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 6px 0;
    font-size: 16px;
}

.task .check-btn {
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
}

.task.done .task-title {
    text-decoration: line-through;
    color: #888;
}

</style>

<form method="POST" action="{{ route('tasks.store', $project['id']) }}">
    @csrf

    <input
        type="text"
        name="title"
        placeholder="Escribe una tarea..."
        required
    >

    <button type="submit">Agregar tarea</button>
</form>


<hr>
<a href="{{ route('dashboard') }}" class="back-btn">
    Volver al inicio
</a>
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

                <button class="check-btn">
                    {{ $task['is_completed'] ? '🟢' : '⭕' }}
                </button>
            </form>

            <span class="task-title">
                {{ $task['title'] }}
            </span>

            <span class="task-status">
                {{ $task['is_completed'] ? 'Completada' : 'Pendiente' }}
            </span>

        </div>
    @endforeach
@endif

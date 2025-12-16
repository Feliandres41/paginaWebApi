<h3>Nueva tarea</h3>

<form method="POST" action="{{ route('tasks.store', $project['id']) }}">
    @csrf

    <input type="text"
           name="title"
           placeholder="Escribe una tarea"
           required
           style="padding:8px; width:250px;">

    <button type="submit">➕ Agregar</button>
</form>

<hr>

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
                    {{ $task['is_completed'] ? '✔️' : '⭕' }}
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


<div class="task {{ $task['is_completed'] ? 'done' : '' }}">

    <form method="POST" action="{{ route('tasks.toggle', $task['id']) }}">
        @csrf
        @method('PATCH')

        <button type="submit" class="check-btn">
            {{ $task['is_completed'] ? '✔' : '○' }}
        </button>
    </form>

    <div class="task-info">
        <span class="task-title">{{ $task['title'] }}</span>

        <span class="task-status">
            {{ $task['is_completed'] ? 'Completada' : 'Pendiente (haz clic para completar)' }}
        </span>
    </div>

</div>

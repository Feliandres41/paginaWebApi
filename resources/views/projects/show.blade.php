<h2>{{ $project['name'] }}</h2>

<h3>Tareas</h3>

@if(empty($project['tasks']))
    <p>No hay tareas</p>
@endif

@foreach($project['tasks'] as $task)
    <form method="POST" action="{{ route('tasks.complete', $task['id']) }}">
        @csrf
        @method('PUT')
        <button {{ $task['is_completed'] ? 'disabled' : '' }}>
            {{ $task['title'] }}
        </button>
    </form>
@endforeach

<form method="POST" action="{{ route('tasks.store') }}">
    @csrf
    <input type="hidden" name="project_id" value="{{ $project['id'] }}">
    <input name="title" placeholder="Nueva tarea">
    <input type="date" name="due_date">
    <button>Agregar tarea</button>
</form>

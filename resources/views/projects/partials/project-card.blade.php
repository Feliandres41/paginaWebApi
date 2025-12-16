<div class="bg-white shadow-md rounded-lg p-4 mb-4">
    <h3 class="text-lg font-semibold">{{ $project['name'] }}</h3>
    <div class="mt-2">
        @foreach($project['tasks'] as $task)
            @include('tasks.partials.task-item', ['task' => $task])
        @endforeach
    </div>
    <form method="POST" action="{{ route('projects.destroy', ['id' => $project['id']]) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 text-white px-4 py-2 mt-4 rounded">Eliminar Proyecto</button>
    </form>
</div>

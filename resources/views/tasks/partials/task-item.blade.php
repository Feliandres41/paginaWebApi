<div class="flex justify-between items-center mt-2">
    <p>{{ $task['title'] }} - 
        @if($task['is_completed'])
            <span class="text-green-500">Completada</span>
        @else
            <span class="text-yellow-500">Pendiente</span>
        @endif
    </p>
    @if(!$task['is_completed'])
        <form method="POST" action="{{ route('tasks.complete', ['id' => $task['id']]) }}">
            @csrf
            @method('PUT')
            <button class="text-blue-500">Marcar como completada</button>
        </form>
    @endif
</div>

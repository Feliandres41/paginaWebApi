<form method="POST" action="{{ route('projects.store') }}">
    @csrf
    <input name="name" placeholder="Nombre del proyecto" required><br><br>
    <textarea name="description" placeholder="Descripcion"></textarea>
    <button>Crear</button>
</form>

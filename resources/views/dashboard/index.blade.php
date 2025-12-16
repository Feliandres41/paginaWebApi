@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <h2>Mis Proyectos</h2>

        <a href="{{ route('projects.create') }}">Crear proyecto</a>

        @if(empty($projects))
            <p>No tienes proyectos creados todavía.</p>
        @else
            @foreach($projects as $project)
                <div>
                    <h3>{{ $project['name'] }}</h3>
                    <a href="{{ route('projects.show', $project['id']) }}">Ver</a>

                    <form method="POST" action="{{ route('projects.destroy', $project['id']) }}">
                        @csrf
                        @method('DELETE')
                        <button>Eliminar</button>
                    </form>
                </div>
            @endforeach
        @endif

    </div>
@endsection

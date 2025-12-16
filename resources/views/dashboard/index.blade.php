@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <h2>Mis Proyectos</h2>

        @if(session('message'))
            <div class="alert alert-warning">
                {{ session('message') }}
            </div>
        @endif

        @if($projects->isEmpty())
            <p>No tienes proyectos creados todavía. <a href="{{ route('projects.create') }}">Crea tu primer proyecto</a></p>
        @else
            <div>
                @foreach($projects as $project)
                    @include('projects.partials.project-card', ['project' => $project])
                @endforeach
            </div>
        @endif
    </div>
@endsection

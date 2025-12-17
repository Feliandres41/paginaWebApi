@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
<div class="container">
    <h2>Iniciar sesión</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" required>

        <button type="submit">Entrar</button>
    </form>
</div>
@endsection

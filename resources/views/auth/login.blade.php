@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
    <div class="container">
        <h2>Iniciar sesión</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div>
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Iniciar sesión</button>
        </form>
        <p>No tienes cuenta? <a href="{{ route('register') }}">Registrarse</a></p>
    </div>
@endsection

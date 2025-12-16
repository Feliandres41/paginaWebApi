@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')
<div class="container">
    <form method="POST" class="formulario" action="{{ route('register.post') }}">
        @csrf

        <div>
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div>
            <label for="password_confirmation">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <div class="botonRegistro">
            <button type="submit">Registrarse</button>
        </div>
    </form>

    <p>Ya tienes cuenta?
        <a href="{{ route('login') }}">Iniciar sesión</a>
    </p>
</div>
@endsection

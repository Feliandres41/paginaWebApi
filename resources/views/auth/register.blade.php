<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
</head>
<body>

    <h2>Registrarse</h2>

    <!-- Mostrar errores si los hay -->
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <!-- Formulario de registro -->
    <form method="POST" action="{{ route('register.post') }}">
        @csrf

        <label for="name">Nombre:</label>
        <input type="text" name="name" value="{{ old('name') }}" required>

        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>

        <label for="password_confirmation">Confirmar contraseña:</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">Registrarse</button>
    </form>

    <a href="{{ route('login') }}">¿Ya tienes cuenta? Inicia sesión</a>

</body>
</html>

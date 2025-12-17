<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Gestor de Proyectos')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <nav class="navbar">
        <h1 class="logo">Gestor de Proyectos</h1>

        @if(session()->has('api_token'))
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-btn">Cerrar sesión</button>
            </form>
        @else
            <div class="auth-links">
                <a href="{{ route('login') }}">Iniciar sesión</a>
                <a href="{{ route('register.get') }}">Registrarse</a>
            </div>
        @endif
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

</body>
</html>

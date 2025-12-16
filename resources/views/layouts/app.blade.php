<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestor de Proyectos')</title>
</head>
<body class="bg-gray-100">

    <nav class="bg-indigo-600 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <h1 class="font-bold text-xl">Gestor de Proyectos</h1>
            <div>
                @if(session('api_token'))
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="bg-red-500 text-white px-4 py-2 rounded">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-white">Iniciar sesión</a> | 
                    <a href="{{ route('register') }}" class="text-white">Registrarse</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8">
        @yield('content')
    </div>

</body>
</html>

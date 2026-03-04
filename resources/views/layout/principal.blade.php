<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="bg-white shadow p-3 flex justify-between items-center">
        <img src="{{ asset('imagenes/logoFranco.jpg') }}" alt="Logo" class="h-12 w-30">
        <h1 class="text-xl font-bold">Sistema SGDP</h1>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 text-white px-4 py-2 rounded">
                Cerrar sesión
            </button>
        </form>
    </div>

    <div class="flex">
        <aside class="w-64 bg-gray-800 text-white min-h-screen p-4 space-y-2">
            <a href="/dashboard" class="block p-2 hover:bg-gray-700 rounded">Dashboard</a>
            <a href="/registrarUsuarios" class="block p-2 hover:bg-gray-700 rounded">Registrar Usuarios</a>
            <a href="/registrar" class="block p-2 hover:bg-gray-700 rounded">Registrar Empleados</a>
            <a href="/registrar" class="block p-2 hover:bg-gray-700 rounded">Registrar Documentos</a>
            <a href="/documentos" class="block p-2 hover:bg-gray-700 rounded">Documentos</a>
            <a href="/tipoDocumentos" class="block p-2 hover:bg-gray-700 rounded">Tipo de Documentos</a>
        </aside>

        {{-- Contenido dinámico --}}
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>

</body>
</html>

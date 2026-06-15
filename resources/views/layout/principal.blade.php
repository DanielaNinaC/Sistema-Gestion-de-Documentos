<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 h-screen overflow-hidden flex flex-col">

    <div class="bg-white shadow p-3 flex justify-between items-center shrink-0">
        <img src="{{ asset('imagenes/logoFranco.jpg') }}" alt="Logo" class="h-12 w-30">
        <h1 class="text-xl font-bold">Sistema SGDP</h1>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 text-white px-4 py-2 rounded">
                Cerrar sesión
            </button>
        </form>
    </div>

    <div class="flex flex-1 min-h-0">
        <aside class="w-64 bg-gray-800 text-white p-4 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="block p-2 hover:bg-gray-700 rounded">Dashboard</a>
            @if(auth()->user()->isAdmin())
                 <a href="{{ route('usuarios.index') }}" class="block p-2 hover:bg-gray-700 rounded">Registrar Usuarios</a>
            @endif
            <a href="{{ route('empleados.index') }}" class="block p-2 hover:bg-gray-700 rounded">Registrar Empleados</a>
              <a href="{{ route('documentos.create') }}" class="block p-2 hover:bg-gray-700 rounded">Registrar Documentos</a>
            <a href="{{ route('documentos.index') }}" class="block p-2 hover:bg-gray-700 rounded">Documentos</a>
            <a href="{{ route('tipos-documentos.index') }}" class="block p-2 hover:bg-gray-700 rounded">Tipo de Documentos</a>
        </aside>

        {{-- Contenido dinámico --}}
        <main class="flex-1 p-8 overflow-y-auto">
            @yield('content')
        </main>
    </div>

</body>
</html>


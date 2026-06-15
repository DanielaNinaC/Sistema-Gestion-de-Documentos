@extends('layout.principal')

@section('title', 'Registrar Usuarios')

@section('content')

<h2 class="text-2xl font-bold mb-6">Registrar Usuario</h2>

@if(session('error'))
    <div class="bg-red-500 text-white p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="bg-green-500 text-white p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-500 text-white p-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('usuarios.store') }}" class="space-y-4 bg-white p-6 rounded-xl shadow">
    @csrf

    <div>
        <label class="block font-semibold">Nombre</label>
        <input type="text" name="name" class="w-full border p-2 rounded-xl" required>
    </div>

    <div>
        <label class="block font-semibold">Correo</label>
        <input type="email" name="email" class="w-full border p-2 rounded-xl" required>
    </div>

    <div>
        <label class="block font-semibold">Contraseña</label>
        <input type="password" name="password" class="w-full border p-2 rounded-xl" required>
    </div>

    <div>
        <label class="block font-semibold">Confirmar Contraseña</label>
        <input type="password" name="password_confirmation" class="w-full border p-2 rounded-xl" required>
    </div>

    <div>
        <label class="block font-semibold">Rol</label>
        <select name="rol" class="w-full border p-2 rounded-xl" required>
            <option value="operador">Operador</option>
            <option value="admin">Administrador</option>
        </select>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded-xl">
        Registrar
    </button>
</form>

<hr class="my-8">

<h3 class="text-xl font-bold mb-4">Usuarios Registrados</h3>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2 text-left">ID</th>
            <th class="p-2 text-left">Nombre</th>
            <th class="p-2 text-left">Correo</th>
            <th class="p-2 text-left">Rol</th>
            <th class="p-2 text-left">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $usuario)
            <tr class="border-t">
                <td class="p-2">{{ $usuario->id }}</td>
                <td class="p-2">{{ $usuario->name }}</td>
                <td class="p-2">{{ $usuario->email }}</td>
                <td class="p-2">
                    @if($usuario->rol === 'admin')
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">Administrador</span>
                    @else
                        <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-2 py-1 rounded-full">Operador</span>
                    @endif
                </td>
                <td class="p-2">
                    <div class="flex gap-2 text-sm">
                        <a href="{{ route('usuarios.edit', $usuario) }}" class="text-blue-600 underline">Editar</a>
                        <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" class="inline" onsubmit="return confirm('¿Eliminar usuario?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 underline">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $usuarios->links() }}
</div>

@endsection
@extends('layout.principal')

@section('title', 'Registrar Usuarios')

@section('content')

<h2 class="text-2xl font-bold mb-6">Registrar Usuario</h2>

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

<form method="POST" action="{{ route('usuarios.store') }}" class="space-y-4 bg-white p-6 rounded shadow">
    @csrf

    <div>
        <label class="block font-semibold">Nombre</label>
        <input type="text" name="name" class="w-full border p-2 rounded" required>
    </div>

    <div>
        <label class="block font-semibold">Correo</label>
        <input type="email" name="email" class="w-full border p-2 rounded" required>
    </div>

    <div>
        <label class="block font-semibold">Contraseña</label>
        <input type="password" name="password" class="w-full border p-2 rounded" required>
    </div>

    <div>
        <label class="block font-semibold">Confirmar Contraseña</label>
        <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
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
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $usuario)
            <tr class="border-t">
                <td class="p-2">{{ $usuario->id }}</td>
                <td class="p-2">{{ $usuario->name }}</td>
                <td class="p-2">{{ $usuario->email }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
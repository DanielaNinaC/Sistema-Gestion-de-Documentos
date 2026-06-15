@extends('layout.principal')

@section('title', 'Editar Usuario')

@section('content')

<h2 class="text-2xl font-bold mb-6">Editar Usuario</h2>

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

<form method="POST" action="{{ route('usuarios.update', $user) }}" class="space-y-4 bg-white p-6 rounded-xl shadow max-w-md">
    @csrf
    @method('PUT')

    <div>
        <label class="block font-semibold">Nombre</label>
        <input type="text" name="name" value="{{ $user->name }}" class="w-full border p-2 rounded-xl" required>
    </div>

    <div>
        <label class="block font-semibold">Correo</label>
        <input type="email" name="email" value="{{ $user->email }}" class="w-full border p-2 rounded-xl" required>
    </div>

    <div>
        <label class="block font-semibold">Rol</label>
        <select name="rol" class="w-full border p-2 rounded-xl" required>
            <option value="operador" @if($user->rol === 'operador') selected @endif>Operador</option>
            <option value="admin" @if($user->rol === 'admin') selected @endif>Administrador</option>
        </select>
    </div>

    <div class="flex gap-2 pt-4">
        <button class="bg-blue-600 text-white px-4 py-2 rounded-xl">
            Actualizar
        </button>
        <a href="{{ route('usuarios.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-xl">
            Cancelar
        </a>
    </div>
</form>

@endsection

@extends('layout.principal')

@section('title', 'Editar Empleado')

@section('content')

<h2 class="text-2xl font-bold mb-6">Editar Empleado</h2>

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

<form method="POST" action="{{ route('empleados.update', $empleado) }}" class="space-y-4 bg-white p-6 rounded-xl shadow max-w-md">
    @csrf
    @method('PUT')

    <div>
        <label class="block font-semibold">Código de Empleado</label>
        <input type="text" name="codigo" value="{{ $empleado->codigo }}" class="w-full border p-2 rounded-xl" required>
    </div>

    <div>
        <label class="block font-semibold">Nombre del Empleado</label>
        <input type="text" name="nombre" value="{{ $empleado->nombre }}" class="w-full border p-2 rounded-xl" required>
    </div>

    <div class="flex gap-2 pt-4">
        <button class="bg-blue-600 text-white px-4 py-2 rounded-xl">
            Actualizar
        </button>
        <a href="{{ route('empleados.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-xl">
            Cancelar
        </a>
    </div>
</form>

@endsection

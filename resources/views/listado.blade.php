@extends('layout.principal')

@section('title', 'Registrar Empleados')

@section('content')

<h2 class="text-2xl font-semibold mb-4">
    Bienvenida, {{ auth()->user()->name }}
</h2>

<p class="text-gray-600">Registra empleados y consulta los ya registrados.</p>

@if(session('success'))
    <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('empleados.store') }}" class="bg-white p-6 rounded shadow space-y-4 mt-6">
    @csrf

    <div>
        <label class="block font-semibold">Codigo de Empleado</label>
        <input type="text" name="codigo" value="{{ old('codigo') }}" class="w-full border p-2 rounded" required>
    </div>

    <div>
        <label class="block font-semibold">Nombre del Empleado</label>
        <input type="text" name="nombre" value="{{ old('nombre') }}" class="w-full border p-2 rounded" required>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Guardar Empleado
    </button>
</form>

<h3 class="text-xl font-semibold mt-8 mb-4">Listado de empleados</h3>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2 text-left">Código</th>
            <th class="p-2 text-left">Empleado</th>
            <th class="p-2 text-left">Fecha de registro</th>
            <th class="p-2 text-left">Opcion</th>
        </tr>
    </thead>
    <tbody>
        @forelse($empleados as $empleado)
            <tr class="border-b">
                <td class="p-2">{{ $empleado->codigo }}</td>
                <td class="p-2">{{ $empleado->nombre }}</td>
                <td class="p-2">{{ $empleado->created_at->format('d/m/Y H:i') }}</td>
                <td class="p-2">
                    <a href="{{ route('empleados.documentos', $empleado->codigo) }}" class="text-blue-600 underline">
                        Ver mas
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td class="p-2" colspan="4">No hay empleados registrados.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection

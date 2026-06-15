@extends('layout.principal')

@section('title', 'Documentos')

@section('content')

<h2 class="text-2xl font-semibold mb-4">
    Bienvenida, {{ auth()->user()->name }}
</h2>

<p class="text-gray-600">Listado de documentos registrados.</p>

@if(session('success'))
    <div class="bg-green-200 text-green-800 p-3 rounded my-4">
        {{ session('success') }}
    </div>
@endif

<form method="GET" action="{{ route('documentos.index') }}" class="bg-white p-4 rounded-xl shadow mt-6 mb-6">
    <label for="busqueda-documentos" class="block font-semibold mb-2">Buscar documento</label>
    <div class="flex flex-col md:flex-row gap-3 md:items-center">
        <input
            id="busqueda-documentos"
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Buscar por código, empleado, archivo o tipo"
            class="w-full md:w-2/3 border p-2 rounded-xl"
        >
        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl">
                Buscar
            </button>
            @if(request('q'))
                <a href="{{ route('documentos.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-xl">
                    Limpiar
                </a>
            @endif
        </div>
    </div>
</form>

<h3 class="text-xl font-semibold mt-8 mb-4">Documentos</h3>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2 text-left">Código</th>
            <th class="p-2 text-left">Empleado</th>
            <th class="p-2 text-left">Archivo</th>
            <th class="p-2 text-left">Tipo</th>
            <th class="p-2 text-left">Acción</th>
        </tr>
    </thead>
    <tbody>
        @forelse($documentos as $registro)
            <tr class="border-b">
                <td class="p-2">{{ $registro->codigo }}</td>
                <td class="p-2">{{ $registro->empleado }}</td>
                <td class="p-2">{{ $registro->archivo_nombre }}</td>
                <td class="p-2">{{ $registro->archivo_tipo }}</td>
                <td class="p-2">
                    <div class="flex items-center gap-3">
                        <a href="{{ asset('storage/' . $registro->ruta_archivo) }}"
                           class="text-blue-600 underline" target="_blank">
                            Ver archivo
                        </a>
                        <a href="{{ route('documentos.edit', $registro) }}" class="text-green-700 underline">
                            Editar
                        </a>
                        @if(auth()->user()->isAdmin())
                            <form method="POST" action="{{ route('documentos.destroy', $registro) }}" class="inline" onsubmit="return confirm('¿Eliminar documento?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 underline">Eliminar</button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="p-4 text-center text-gray-500">
                    No se encontraron documentos con ese criterio.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $documentos->appends(request()->query())->links() }}
</div>

@endsection

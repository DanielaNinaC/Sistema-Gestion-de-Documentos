@extends('layout.principal')

@section('title', 'Tipo de Documentos')

@section('content')

<h2 class="text-2xl font-semibold mb-4">
    Bienvenida, {{ auth()->user()->name }}
</h2>

<p class="text-gray-600">Registra y administra los tipos de documentos disponibles.</p>

@if(session('success'))
    <div class="bg-green-200 text-green-800 p-3 rounded my-4">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-200 text-red-800 p-3 rounded my-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('tipos-documentos.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow mb-8">
    @csrf

    <div class="flex flex-col md:flex-row md:items-end gap-4">
        <div class="flex-1">
            <label class="block font-semibold mb-2">Nombre del Tipo de Documento</label>
            <input
                type="text"
                name="nombre"
                value="{{ old('nombre') }}"
                class="w-full border p-2 rounded-xl"
                placeholder="Ej: Contrato, Memorandum, Informe"
                required
            >
        </div>
        <button class="bg-blue-600 text-white px-4 py-2 rounded-xl h-10">
            Registrar Tipo
        </button>
    </div>
</form>

<h3 class="text-xl font-semibold mt-8 mb-4">Tipos de documentos</h3>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2 text-left">Tipo de Documento</th>
            <th class="p-2 text-left">Cantidad</th>
            @if(auth()->user()->isAdmin())
                <th class="p-2 text-left">Acciones</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse($tipos as $tipo)
            <tr class="border-b">
                <td class="p-2">{{ $tipo->nombre }}</td>
                <td class="p-2">{{ $tipo->total }}</td>
                @if(auth()->user()->isAdmin())
                    <td class="p-2">
                        <div class="flex gap-2 text-sm">
                            <a href="{{ route('tipos-documentos.edit', $tipo) }}" class="text-yellow-600 underline">
                                Editar
                            </a>
                            <form method="POST" action="{{ route('tipos-documentos.destroy', $tipo) }}" class="inline" onsubmit="return confirm('¿Eliminar tipo de documento?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 underline">Eliminar</button>
                            </form>
                        </div>
                    </td>
                @endif
            </tr>
        @empty
            <tr>
                <td class="p-2" colspan="3">No hay tipos registrados.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection

@extends('layout.principal')

@section('title', 'Documentos del Empleado')

@section('content')

<h2 class="text-2xl font-semibold mb-2">Documentos de {{ $empleado->nombre }}</h2>
<p class="text-gray-600 mb-6">Codigo: {{ $empleado->codigo }}</p>

<div class="mb-6">
    <a href="{{ route('empleados.index') }}" class="text-blue-600 underline">Volver al listado de empleados</a>
</div>

<h3 class="text-xl font-semibold mb-4">Documentos guardados</h3>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2 text-left">Nombre de Archivo</th>
            <th class="p-2 text-left">Tipo</th>
            <th class="p-2 text-left">Fecha</th>
            <th class="p-2 text-left">Accion</th>
        </tr>
    </thead>
    <tbody>
        @forelse($registros as $registro)
            <tr class="border-b">
                <td class="p-2">{{ $registro->archivo_nombre }}</td>
                <td class="p-2">{{ $registro->archivo_tipo }}</td>
                <td class="p-2">{{ $registro->created_at->format('d/m/Y H:i') }}</td>
                <td class="p-2">
                    <a href="{{ asset('storage/' . $registro->ruta_archivo) }}" class="text-blue-600 underline" target="_blank">
                        Ver archivo
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td class="p-2" colspan="4">Este empleado aun no tiene documentos registrados.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection

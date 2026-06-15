@extends('layout.principal')

@section('title', 'Dashboard')

@section('content')

<h2 class="text-2xl font-semibold mb-4">
    Bienvenida, {{ auth()->user()->name }}
</h2>

<p class="text-gray-600">Este es tu panel principal del sistema.</p>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
    <div class="bg-white shadow rounded p-5">
        <p class="text-sm text-gray-500">Documentos registrados</p>
        <p class="text-3xl font-bold mt-2">{{ $totalDocumentos }}</p>
    </div>

    <div class="bg-white shadow rounded p-5">
        <p class="text-sm text-gray-500">Empleados con documentos</p>
        <p class="text-3xl font-bold mt-2">{{ $totalEmpleados }}</p>
    </div>

    <div class="bg-white shadow rounded p-5">
        <p class="text-sm text-gray-500">Tipos de documento</p>
        <p class="text-3xl font-bold mt-2">{{ $totalTipos }}</p>
    </div>
</div>

<div class="bg-white shadow rounded p-5 mt-8">
    <h3 class="text-xl font-semibold mb-4">Acciones rápidas</h3>
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('documentos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Registrar documento</a>
        <a href="{{ route('documentos.index') }}" class="bg-gray-700 text-white px-4 py-2 rounded">Ver documentos</a>
        <a href="{{ route('tipos-documentos.index') }}" class="bg-green-700 text-white px-4 py-2 rounded">Ver tipos</a>
    </div>
</div>

<div class="bg-white shadow rounded p-5 mt-8">
    <h3 class="text-xl font-semibold mb-4">Últimos documentos</h3>
    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Codigo</th>
                <th class="p-2 text-left">Empleado</th>
                <th class="p-2 text-left">Archivo</th>
                <th class="p-2 text-left">Tipo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ultimosDocumentos as $registro)
                <tr class="border-b">
                    <td class="p-2">{{ $registro->codigo }}</td>
                    <td class="p-2">{{ $registro->empleado }}</td>
                    <td class="p-2">{{ $registro->archivo_nombre }}</td>
                    <td class="p-2">{{ $registro->archivo_tipo }}</td>
                </tr>
            @empty
                <tr>
                    <td class="p-2" colspan="4">No hay documentos todavía.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection


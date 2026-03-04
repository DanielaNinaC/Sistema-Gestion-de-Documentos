@extends('layout.principal')

@section('title', 'Dashboard')

@section('content')

<h2 class="text-2xl font-semibold mb-4">
    Bienvenida, {{ auth()->user()->name }}
</h2>

<p class="text-gray-600">
    Este es tu panel principal del sistema.
</p>

<h3 class="text-xl font-semibold mt-8 mb-4">Registros de usuarios</h3>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2 text-left">Código</th>
            <th class="p-2 text-left">Empleado</th>
            <th class="p-2 text-left">Archivo</th>
            <th class="p-2 text-left">Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach($registros as $registro)
            <tr class="border-b">
                <td class="p-2">{{ $registro->codigo }}</td>
                <td class="p-2">{{ $registro->empleado }}</td>
                <td class="p-2">{{ $registro->archivo_nombre }}</td>
                <td class="p-2">
                    <a href="{{ asset('storage/' . $registro->ruta_archivo) }}"
                       class="text-blue-600 underline" target="_blank">
                        Ver archivo/Ver más
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection

@extends('layout.principal')

@section('title', 'Editar Documento')

@section('content')

<h2 class="text-2xl font-semibold mb-4">Editar Documento</h2>

@if ($errors->any())
    <div class="bg-red-200 text-red-800 p-3 rounded my-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('documentos.update', $registro) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block font-semibold">Codigo</label>
        <input type="text" value="{{ $registro->codigo }}" class="w-full border p-2 rounded-xl bg-gray-100" readonly>
    </div>

    <div>
        <label class="block font-semibold">Empleado</label>
        <input type="text" value="{{ $registro->empleado }}" class="w-full border p-2 rounded-xl bg-gray-100" readonly>
    </div>

    <div>
        <label class="block font-semibold">Nombre del Archivo</label>
        <input
            type="text"
            name="archivo_nombre"
            value="{{ old('archivo_nombre', $registro->archivo_nombre) }}"
            class="w-full border p-2 rounded-xl"
            required
        >
    </div>

    <div>
        <label class="block font-semibold">Tipo de Archivo</label>
        <select name="archivo_tipo" class="w-full border p-2 rounded-xl" required>
            @foreach($tipos as $tipo)
                <option value="{{ $tipo->nombre }}" {{ old('archivo_tipo', $registro->archivo_tipo) === $tipo->nombre ? 'selected' : '' }}>
                    {{ $tipo->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-semibold">Reemplazar Archivo (opcional)</label>
        <input type="file" name="archivo" class="w-full border p-2 rounded-xl" accept=".pdf,.doc,.docx">
        <p class="text-sm text-gray-600 mt-2">Si no seleccionas un archivo, se conserva el actual.</p>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl">Guardar cambios</button>
        <a href="{{ route('documentos.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-xl">Cancelar</a>
    </div>
</form>

@endsection


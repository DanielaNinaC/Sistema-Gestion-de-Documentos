@extends('layout.principal')

@section('title', 'Registrar Documento')

@section('content')

<h2 class="text-2xl font-bold mb-6">Registrar Documento</h2>

@if(session('success'))
    <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<form action="/registrar" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-4">
    @csrf

    <div>
        <label class="block font-semibold">Código</label>
        <input type="text" name="codigo" class="w-full border p-2 rounded" required>
    </div>

    <div>
        <label class="block font-semibold">Nombre del Empleado</label>
        <input type="text" name="empleado" class="w-full border p-2 rounded" required>
    </div>

    <div>
        <label class="block font-semibold">Nombre del Archivo</label>
        <input type="text" name="archivo_nombre" class="w-full border p-2 rounded" required>
    </div>
    <div>
        <label class="block font-semibold">Tipo de Archivo</label>
        <select name="archivo_tipo" class="w-full border p-2 rounded" required>
        
            <option value="">Seleccione una opción</option>
            <option value="Contrato" {{ old('archivo_tipo') == 'Contrato' ? 'selected' : '' }}>Contrato</option>
            <option value="Memorandum" {{ old('archivo_tipo') == 'Memorandum' ? 'selected' : '' }}>Memorandum</option>
            <option value="Informe" {{ old('archivo_tipo') == 'Informe' ? 'selected' : '' }}>Informe</option>
            <option value="Solicitud" {{ old('archivo_tipo') == 'Solicitud' ? 'selected' : '' }}>Solicitud</option>
        </select>
    </div>

    <div>
        <label class="block font-semibold">Cargar Archivo (PDF o Word)</label>
        <input type="file" name="archivo" class="w-full border p-2 rounded" accept=".pdf,.doc,.docx" required>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Guardar Registro
    </button>
</form>

@endsection

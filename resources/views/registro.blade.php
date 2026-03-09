@extends('layout.principal')

@section('title', 'Registrar Documento')

@section('content')

<h2 class="text-2xl font-bold mb-6">Registrar Documento</h2>

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

@php
    $oldNombres = old('archivo_nombre', ['']);
    $oldTipos = old('archivo_tipo', ['']);
    $documentosCount = max(count($oldNombres), count($oldTipos), 1);
    $sinTipos = $tipos->isEmpty();
@endphp

<form action="{{ route('registros.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-4">
    @csrf

    <div>
        <label class="block font-semibold">Código</label>
        <input id="codigo-empleado" type="text" name="codigo" value="{{ old('codigo') }}" class="w-full border p-2 rounded" required>
    </div>

    <div>
        <label class="block font-semibold">Nombre del Empleado</label>
        <input id="nombre-empleado" type="text" name="empleado" value="{{ old('empleado') }}" class="w-full border p-2 rounded bg-gray-100" readonly>
        <p id="mensaje-empleado" class="text-sm mt-2 text-gray-600"></p>
    </div>

    <div id="documentos-container" class="space-y-4">
        @for ($i = 0; $i < $documentosCount; $i++)
            <div class="documento-item border rounded p-4 bg-gray-50 space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-gray-700">Documento #{{ $i + 1 }}</h3>
                    <button type="button" class="btn-eliminar-doc text-red-600 text-sm {{ $i === 0 ? 'hidden' : '' }}">Quitar</button>
                </div>

                <div>
                    <label class="block font-semibold">Nombre del Archivo</label>
                    <input
                        type="text"
                        name="archivo_nombre[]"
                        value="{{ $oldNombres[$i] ?? '' }}"
                        class="w-full border p-2 rounded"
                        required
                    >
                </div>

                <div>
                    <label class="block font-semibold">Tipo de Archivo</label>
                    <select name="archivo_tipo[]" class="w-full border p-2 rounded" required>
                        <option value="">Seleccione una opción</option>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo->nombre }}" {{ ($oldTipos[$i] ?? '') == $tipo->nombre ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold">Cargar Archivo (PDF o Word)</label>
                    <input type="file" name="archivo[]" class="w-full border p-2 rounded" accept=".pdf,.doc,.docx" required>
                </div>
            </div>
        @endfor
    </div>

    <div class="flex flex-col items-start gap-3 pt-2">
        <button type="button" id="agregar-documento" class="bg-gray-700 text-white px-4 py-2 rounded" {{ $sinTipos ? 'disabled' : '' }}>
            Registrar un documento mas
        </button>
        <button class="bg-blue-600 text-white px-4 py-2 rounded" {{ $sinTipos ? 'disabled' : '' }}>
            Guardar Registros
        </button>
    </div>

    @if($sinTipos)
        <p class="text-sm text-red-600 mt-2">
            Primero registra al menos un tipo de documento en el modulo "Tipo de Documentos".
        </p>
    @endif
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('documentos-container');
    const addButton = document.getElementById('agregar-documento');
    const codigoInput = document.getElementById('codigo-empleado');
    const nombreInput = document.getElementById('nombre-empleado');
    const mensajeEmpleado = document.getElementById('mensaje-empleado');

    let codigoTimer;

    async function buscarEmpleadoPorCodigo(codigo) {
        if (!codigo) {
            nombreInput.value = '';
            mensajeEmpleado.textContent = '';
            return;
        }

        mensajeEmpleado.textContent = 'Buscando empleado...';
        mensajeEmpleado.className = 'text-sm mt-2 text-gray-600';

        try {
            const respuesta = await fetch(`/empleados/buscar/${encodeURIComponent(codigo)}`);

            if (!respuesta.ok) {
                throw new Error('Empleado no encontrado');
            }

            const data = await respuesta.json();
            nombreInput.value = data.nombre || '';
            mensajeEmpleado.textContent = 'Empleado encontrado';
            mensajeEmpleado.className = 'text-sm mt-2 text-green-600';
        } catch (error) {
            nombreInput.value = '';
            mensajeEmpleado.textContent = 'No existe un empleado con ese codigo';
            mensajeEmpleado.className = 'text-sm mt-2 text-red-600';
        }
    }

    if (codigoInput) {
        codigoInput.addEventListener('input', function (event) {
            const codigo = event.target.value.trim();

            clearTimeout(codigoTimer);
            codigoTimer = setTimeout(function () {
                buscarEmpleadoPorCodigo(codigo);
            }, 300);
        });

        if (codigoInput.value.trim().length > 0 && !nombreInput.value.trim()) {
            buscarEmpleadoPorCodigo(codigoInput.value.trim());
        }
    }

    function updateTitles() {
        const items = container.querySelectorAll('.documento-item');
        items.forEach(function (item, index) {
            const title = item.querySelector('h3');
            const removeButton = item.querySelector('.btn-eliminar-doc');

            title.textContent = 'Documento #' + (index + 1);
            if (index === 0) {
                removeButton.classList.add('hidden');
            } else {
                removeButton.classList.remove('hidden');
            }
        });
    }

    if (addButton) {
        addButton.addEventListener('click', function () {
            const lastItem = container.querySelector('.documento-item:last-child');
            const newItem = lastItem.cloneNode(true);

            newItem.querySelectorAll('input').forEach(function (input) {
                if (input.type === 'file' || input.type === 'text') {
                    input.value = '';
                }
            });

            const select = newItem.querySelector('select');
            if (select) {
                select.value = '';
            }

            container.appendChild(newItem);
            updateTitles();
        });
    }

    container.addEventListener('click', function (event) {
        if (!event.target.classList.contains('btn-eliminar-doc')) {
            return;
        }

        const items = container.querySelectorAll('.documento-item');
        if (items.length <= 1) {
            return;
        }

        event.target.closest('.documento-item').remove();
        updateTitles();
    });

    updateTitles();
});
</script>

@endsection

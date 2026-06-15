<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRegistroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => 'required|string|exists:empleados,codigo',
            'empleado' => 'nullable|string|max:255',
            'archivo_nombre' => 'required|array|min:1|max:5',
            'archivo_nombre.*' => 'required|string|min:3|max:255',
            'archivo_tipo' => 'required|array|min:1|max:5',
            'archivo_tipo.*' => ['required', Rule::exists('tipos_documentos', 'nombre')],
            'archivo' => 'required|array|min:1|max:5',
            'archivo.*' => 'required|mimes:pdf,doc,docx|max:20480|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required' => 'El código del empleado es requerido.',
            'codigo.exists' => 'El código del empleado no existe.',
            'archivo_nombre.required' => 'Debe ingresar al menos un nombre de documento.',
            'archivo_nombre.array' => 'Los nombres deben ser un conjunto.',
            'archivo_nombre.max' => 'No puede registrar más de 5 documentos a la vez.',
            'archivo_nombre.*.required' => 'Todos los nombres de documentos son requeridos.',
            'archivo_nombre.*.min' => 'El nombre de documento debe tener al menos 3 caracteres.',
            'archivo_nombre.*.max' => 'El nombre de documento es muy largo.',
            'archivo_tipo.required' => 'Debe seleccionar el tipo de documento.',
            'archivo_tipo.*.exists' => 'El tipo de documento seleccionado no existe.',
            'archivo.required' => 'Debe seleccionar al menos un archivo.',
            'archivo.max' => 'No puede enviar más de 5 archivos a la vez.',
            'archivo.*.required' => 'Todos los archivos son requeridos.',
            'archivo.*.mimes' => 'Los archivos deben ser PDF, DOC o DOCX.',
            'archivo.*.max' => 'Cada archivo no puede exceder 20MB.',
            'archivo.*.min' => 'El archivo no puede estar vacío.',
        ];
    }
}

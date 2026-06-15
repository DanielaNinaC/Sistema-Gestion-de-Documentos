<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmpleadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => 'required|string|min:3|max:50|unique:empleados,codigo|regex:/^[A-Z0-9]+$/',
            'nombre' => 'required|string|min:3|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required' => 'El código del empleado es requerido.',
            'codigo.min' => 'El código debe tener al menos 3 caracteres.',
            'codigo.max' => 'El código no puede exceder 50 caracteres.',
            'codigo.unique' => 'Este código de empleado ya existe.',
            'codigo.regex' => 'El código solo puede contener letras mayúsculas y números.',
            'nombre.required' => 'El nombre del empleado es requerido.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
        ];
    }
}

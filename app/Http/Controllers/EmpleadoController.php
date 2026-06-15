<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Registro;
use App\Http\Requests\StoreEmpleadoRequest;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::orderBy('nombre')->paginate(15);

        return view('listado', compact('empleados'));
    }

    public function store(StoreEmpleadoRequest $request)
    {
        $validated = $request->validated();
        Empleado::create($validated);

        return redirect()
            ->route('empleados.index')
            ->with('success', 'Empleado registrado correctamente.');
    }

    public function edit(Empleado $empleado)
    {
        return view('empleados-editar', compact('empleado'));
    }

    public function buscarPorCodigo(string $codigo)
    {
        $empleado = Empleado::where('codigo', $codigo)->first();

        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        return response()->json([
            'codigo' => $empleado->codigo,
            'nombre' => $empleado->nombre,
        ]);
    }

    public function documentos(string $codigo)
    {
        $empleado = Empleado::where('codigo', $codigo)->firstOrFail();

        $documentos = Registro::where('codigo', $empleado->codigo)
            ->latest()
            ->get();

        return view('empleado-documentos', compact('empleado', 'documentos'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|min:3|max:50|regex:/^[A-Z0-9]+$/|unique:empleados,codigo,' . $empleado->id,
            'nombre' => 'required|string|min:3|max:255',
        ]);

        $empleado->update($validated);

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    public function destroy(Empleado $empleado)
    {
        if (Registro::where('codigo', $empleado->codigo)->count() > 0) {
            return back()->with('error', 'No se puede eliminar un empleado que tiene documentos asociados.');
        }

        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }
}

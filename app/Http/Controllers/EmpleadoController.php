<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Registro;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::orderBy('nombre')->get();

        return view('listado', compact('empleados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:50|unique:empleados,codigo',
            'nombre' => 'required|string|max:255',
        ]);

        Empleado::create($validated);

        return redirect()
            ->route('empleados.index')
            ->with('success', 'Empleado registrado correctamente.');
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

        $registros = Registro::where('codigo', $empleado->codigo)
            ->latest()
            ->get();

        return view('empleado-documentos', compact('empleado', 'registros'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use App\Models\Empleado;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RegistroController extends Controller
{
    public function index()
    {
        $registros = Registro::latest()->get();

        return view('documentos', compact('registros'));
    }

    public function create()
    {
        $tipos = TipoDocumento::orderBy('nombre')->get();

        return view('registro', compact('tipos'));
    }

    public function tipos()
    {
        $tipos = TipoDocumento::query()
            ->leftJoin('registros', 'registros.archivo_tipo', '=', 'tipos_documentos.nombre')
            ->select('tipos_documentos.id', 'tipos_documentos.nombre', DB::raw('count(registros.id) as total'))
            ->groupBy('tipos_documentos.id', 'tipos_documentos.nombre')
            ->orderBy('tipos_documentos.nombre')
            ->get();

        return view('tipo-documentos', compact('tipos'));
    }

    public function storeTipo(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:tipos_documentos,nombre',
        ]);

        TipoDocumento::create([
            'nombre' => trim($request->nombre),
        ]);

        return back()->with('success', 'Tipo de documento registrado correctamente');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|exists:empleados,codigo',
            'empleado' => 'nullable|string|max:255',
            'archivo_nombre' => 'required|array|min:1',
            'archivo_nombre.*' => 'required|string|max:255',
            'archivo_tipo' => 'required|array|min:1',
            'archivo_tipo.*' => ['required', Rule::exists('tipos_documentos', 'nombre')],
            'archivo' => 'required|array|min:1',
            'archivo.*' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $empleado = Empleado::where('codigo', $request->codigo)->first();

        $archivos = $request->file('archivo');
        $nombres = $request->archivo_nombre;
        $tipos = $request->archivo_tipo;

        foreach ($archivos as $index => $archivo) {
            $ruta = $archivo->store('documentos', 'public');

            Registro::create([
                'codigo' => $request->codigo,
                'empleado' => $empleado->nombre,
                'archivo_nombre' => $nombres[$index],
                'archivo_tipo' => $tipos[$index],
                'ruta_archivo' => $ruta,
            ]);
        }

        return back()->with('success', 'Documentos registrados correctamente');
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;

class RegistroController extends Controller
{
     public function create()
    {
        return view('registro');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'empleado' => 'required',
            'archivo_nombre' => 'required',
            'archivo' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        
        $ruta = $request->file('archivo')->store('documentos', 'public');

       
        Registro::create([
            'codigo' => $request->codigo,
            'empleado' => $request->empleado,
            'archivo_nombre' => $request->archivo_nombre,
            'ruta_archivo' => $ruta,
        ]);

        return back()->with('success', 'Registro guardado correctamente');
    }
}


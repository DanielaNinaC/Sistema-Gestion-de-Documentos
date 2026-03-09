<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro; 

class DashboardController extends Controller
{
    public function index()
    {
        $totalDocumentos = Registro::count();
        $totalEmpleados = Registro::distinct('empleado')->count('empleado');
        $totalTipos = Registro::distinct('archivo_tipo')->count('archivo_tipo');

        $ultimosRegistros = Registro::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalDocumentos',
            'totalEmpleados',
            'totalTipos',
            'ultimosRegistros'
        ));
    }
}


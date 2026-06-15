<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use App\Models\Empleado;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDocumentos = Registro::count();
        $totalEmpleados = Empleado::count();
        $totalTipos = Registro::distinct('archivo_tipo')->count('archivo_tipo');

        $ultimosDocumentos = Registro::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalDocumentos',
            'totalEmpleados',
            'totalTipos',
            'ultimosDocumentos'
        ));
    }
}


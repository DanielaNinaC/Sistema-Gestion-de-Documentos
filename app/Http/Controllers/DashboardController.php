<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro; 

class DashboardController extends Controller
{
    public function index()
    {
        $registros = Registro::all();
        return view('dashboard', compact('registros'));
    }
}


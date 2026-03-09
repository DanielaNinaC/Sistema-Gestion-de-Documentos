<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EmpleadoController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('registrarUsuarios', [UsuarioController::class, 'index'])
    ->middleware('auth')
    ->name('usuarios.index');
Route::post('/registrarUsuarios', [UsuarioController::class, 'store'])
    ->middleware('auth')
    ->name('usuarios.store');

Route::get('/registrar', [RegistroController::class, 'create'])
    ->middleware('auth')
    ->name('registros.create');
Route::post('/registrar', [RegistroController::class, 'store'])
    ->middleware('auth')
    ->name('registros.store');

Route::get('/documentos', [RegistroController::class, 'index'])
    ->middleware('auth')
    ->name('documentos.index');

Route::get('/registrarEmpleados', [EmpleadoController::class, 'index'])
    ->middleware('auth')
    ->name('empleados.index');
Route::post('/registrarEmpleados', [EmpleadoController::class, 'store'])
    ->middleware('auth')
    ->name('empleados.store');
Route::get('/empleados/buscar/{codigo}', [EmpleadoController::class, 'buscarPorCodigo'])
    ->middleware('auth')
    ->name('empleados.buscar');
Route::get('/empleados/{codigo}/documentos', [EmpleadoController::class, 'documentos'])
    ->middleware('auth')
    ->name('empleados.documentos');

Route::get('/tipoDocumentos', [RegistroController::class, 'tipos'])
    ->middleware('auth')
    ->name('tipos-documentos.index');

Route::post('/tipoDocumentos', [RegistroController::class, 'storeTipo'])
    ->middleware('auth')
    ->name('tipos-documentos.store');
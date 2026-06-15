<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EmpleadoController;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('registrarUsuarios', [UsuarioController::class, 'index'])
    ->middleware(['auth', 'rol:admin'])
    ->name('usuarios.index');
Route::post('/registrarUsuarios', [UsuarioController::class, 'store'])
    ->middleware(['auth', 'rol:admin'])
    ->name('usuarios.store');
Route::get('/usuarios/{user}/editar', [UsuarioController::class, 'edit'])
    ->middleware(['auth', 'rol:admin'])
    ->name('usuarios.edit');
Route::put('/usuarios/{user}', [UsuarioController::class, 'update'])
    ->middleware(['auth', 'rol:admin'])
    ->name('usuarios.update');
Route::delete('/usuarios/{user}', [UsuarioController::class, 'destroy'])
    ->middleware(['auth', 'rol:admin'])
    ->name('usuarios.destroy');

Route::get('/registrar', [RegistroController::class, 'create'])
    ->middleware('auth')
    ->name('documentos.create');
Route::post('/registrar', [RegistroController::class, 'store'])
    ->middleware('auth')
    ->name('documentos.store');

Route::get('/documentos', [RegistroController::class, 'index'])
    ->middleware('auth')
    ->name('documentos.index');
Route::get('/documentos/{registro}/editar', [RegistroController::class, 'edit'])
    ->middleware('auth')
    ->name('documentos.edit');
Route::put('/documentos/{registro}', [RegistroController::class, 'update'])
    ->middleware('auth')
    ->name('documentos.update');
Route::delete('/documentos/{registro}', [RegistroController::class, 'destroy'])
    ->middleware(['auth', 'rol:admin'])
    ->name('documentos.destroy');

Route::get('/registrarEmpleados', [EmpleadoController::class, 'index'])
    ->middleware('auth')
    ->name('empleados.index');
Route::post('/registrarEmpleados', [EmpleadoController::class, 'store'])
    ->middleware('auth')
    ->name('empleados.store');
Route::get('/empleados/{empleado}/editar', [EmpleadoController::class, 'edit'])
    ->middleware(['auth', 'rol:admin'])
    ->name('empleados.edit');
Route::put('/empleados/{empleado}', [EmpleadoController::class, 'update'])
    ->middleware(['auth', 'rol:admin'])
    ->name('empleados.update');
Route::delete('/empleados/{empleado}', [EmpleadoController::class, 'destroy'])
    ->middleware(['auth', 'rol:admin'])
    ->name('empleados.destroy');
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
Route::get('/tipoDocumentos/{tipoDocumento}/editar', [RegistroController::class, 'editTipo'])
    ->middleware(['auth', 'rol:admin'])
    ->name('tipos-documentos.edit');
Route::put('/tipoDocumentos/{tipoDocumento}', [RegistroController::class, 'updateTipo'])
    ->middleware(['auth', 'rol:admin'])
    ->name('tipos-documentos.update');
Route::delete('/tipoDocumentos/{tipoDocumento}', [RegistroController::class, 'destroyTipo'])
    ->middleware(['auth', 'rol:admin'])
    ->name('tipos-documentos.destroy');
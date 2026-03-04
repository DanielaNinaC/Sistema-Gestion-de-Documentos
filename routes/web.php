<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DocumentoController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('registrarUsuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
Route::post('/registrarUsuarios', [UsuarioController::class, 'store'])->name('usuarios.store');

Route::get('/registrar', [RegistroController::class, 'create'])->middleware('auth');
Route::post('/registrar', [RegistroController::class, 'store'])->middleware('auth');

Route::get('/documentos', [DocumentoController::class, 'index'])
     ->name('documentos.index');


Route::get('/documentos', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('documentos');
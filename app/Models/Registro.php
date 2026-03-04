<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    //
    protected $fillable = [
    'codigo',
    'empleado',
    'archivo_nombre',
    'archivo_tipo',
    'ruta_archivo'
];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipos_documentos';

    protected $fillable = [
        'nombre',
    ];

    public function documentos()
    {
        return $this->hasMany(Registro::class, 'archivo_tipo', 'nombre');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inversion2 extends Model
{
    protected $table = 'inversion2';
    protected $primaryKey = 'ID_Inversion';
    public $timestamps = false;

    protected $fillable = [
        'FK_ID_Usuario',
        'FK_ID_Proyecto',
        'FK_ID_Tipo',
        'Monto',
        'Fecha',
        'Descripcion'
    ];

    // Relación con usuario2 (pero usando el modelo Usuario)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'FK_ID_Usuario', 'ID_Usuario');
    }
}
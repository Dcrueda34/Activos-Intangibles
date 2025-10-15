<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = 'ubicacion';          // nombre de tu tabla
    protected $primaryKey = 'ID_Ubicacion';  // PK
    public $timestamps = false;              // si no tienes created_at / updated_at
    protected $fillable = [
        'FK_ID_Pais',
        'FK_ID_Departamento',
        'FK_ID_Municipio',
        'direccion',
    ];

    // Relaciones
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'FK_ID_Pais', 'ID_Pais');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'FK_ID_Departamento', 'ID_Departamento');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'FK_ID_Municipio', 'ID_Municipio');
    }
}

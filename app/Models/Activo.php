<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activo extends Model
{
    use HasFactory;

    protected $table = 'activos';

    protected $fillable = [
        'empresa_id',
        'nombre',
        'tipo',
        'valor',
        'vida_util',
        'estado',
    ];

    /**
     * Relación: un activo pertenece a una empresa.
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
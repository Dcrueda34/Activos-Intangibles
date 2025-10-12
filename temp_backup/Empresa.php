<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas'; // Nombre real de la tabla

    protected $fillable = [
        'nombre',
        'nit',
        'fecha',
        'descripcion',
        'certificado',
        'created_at',
        'updated_at',
    ];
}
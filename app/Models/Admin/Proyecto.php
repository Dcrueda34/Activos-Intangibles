<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyecto'; // 👈 nombre exacto de la tabla
    protected $primaryKey = 'ID_Proyecto'; // 👈 nombre de la clave primaria
    public $timestamps = true;

    // 👇 campos que se pueden guardar
    protected $fillable = [
        'nombre',
        'fecha',
        'descripcion',
        'certificado',
        'liquidado'
    ];
}

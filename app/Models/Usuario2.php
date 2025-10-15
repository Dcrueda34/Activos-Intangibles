<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario2 extends Model
{
    protected $table = 'usuario2';
    protected $primaryKey = 'ID_Usuario';
    public $timestamps = false;
    protected $fillable = ['Nombre', 'Apellido', 'Email']; // agrega columnas según tu tabla
}

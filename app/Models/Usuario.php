<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuario2';        // Nombre real de la tabla
    protected $primaryKey = 'ID_Usuario'; // Clave primaria
    public $timestamps = false;           // No hay created_at / updated_at

    protected $fillable = [
        'ID_Usuario',
        'Nombre',
        'Apellido',
        'Telefono',
        'Correo',
        'Contraseña',
        'Fecha',
        'FK_ID_Municipio',
        'FK_ID_Rol'
    ];

    protected $hidden = ['Contraseña'];

    // Método requerido por Authenticatable (para autenticación)
    public function getAuthPassword()
    {
        return $this->Contraseña;
    }

    // Relación con proyectos (ajústala si no existe esta tabla)
    public function proyectos()
    {
        return $this->belongsToMany(
            Proyecto::class,
            'proyecto_usuario',
            'FK_ID_Usuario',
            'FK_ID_Proyecto'
        );
    }
}
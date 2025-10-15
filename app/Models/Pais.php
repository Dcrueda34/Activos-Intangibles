<?php

// Pais.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'pais';
    protected $primaryKey = 'ID_Pais';
    public $timestamps = false;

    public function departamentos()
    {
        return $this->hasMany(Departamento::class, 'FK_ID_Pais', 'ID_Pais');
    }
}

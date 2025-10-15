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

// Departamento.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamento';
    protected $primaryKey = 'ID_Departamento';
    public $timestamps = false;

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'FK_ID_Pais', 'ID_Pais');
    }

    public function ciudades()
    {
        return $this->hasMany(Ciudad::class, 'FK_ID_Departamento', 'ID_Departamento');
    }
}

// Ciudad.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'ciudad';
    protected $primaryKey = 'ID_Ciudad';
    public $timestamps = false;

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'FK_ID_Departamento', 'ID_Departamento');
    }
}

<?php

use Illuminate\Support\Facades\Artisan;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\Municipio;

Artisan::command('check:ubicacion', function () {
    $this->info('📊 Conteo actual de ubicación:');
    $this->info('Paises: ' . Pais::count());
    $this->info('Departamentos: ' . Departamento::count());
    $this->info('Municipios: ' . Municipio::count());
})->describe('Muestra cuántos países, departamentos y municipios hay en la base de datos.');

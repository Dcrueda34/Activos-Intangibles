<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CatalogoUbicacionController extends Controller
{
    public function getPaises() {}
    public function getDepartamentos($paisId) {}
    public function getMunicipios($departamentoId) {}
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\Municipio;
use Illuminate\Http\Request;

class CatalogoUbicacionController extends Controller
{
    /**
     * Obtener lista de países
     */
    public function getPaises()
    {
        return response()->json(
            Pais::select('ID_Pais', 'Nombre')->orderBy('Nombre')->get()
        );
    }

    /**
     * Obtener departamentos según país
     */
    public function getDepartamentos($paisId)
    {
        $departamentos = Departamento::where('FK_ID_Pais', $paisId)
            ->select('ID_Departamento', 'Nombre')
            ->orderBy('Nombre')
            ->get();

        return response()->json($departamentos);
    }

    /**
     * Obtener municipios según departamento
     */
    public function getMunicipios($departamentoId)
    {
        $municipios = Municipio::where('FK_ID_Departamento', $departamentoId)
            ->select('ID_Municipio', 'Nombre')
            ->orderBy('Nombre')
            ->get();

        return response()->json($municipios);
    }
}

<?php

namespace App\Http\Controllers\ActivosIntangibles;

use App\Http\Controllers\Controller;
use App\Models\Valoracion;
use Illuminate\Http\Request;

class ValoracionController extends Controller
{
    public function index()
    {
        $valoraciones = Valoracion::with('proyecto')->get();
        return response()->json($valoraciones);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'FK_ID_Proyecto' => 'required|exists:proyecto,ID_Proyecto',
            'nombre_producto' => 'nullable|string|max:255',
            'cantidad_vender' => 'nullable|integer',
            'politica_crecimiento' => 'nullable|numeric',
            'politica_precios' => 'nullable|numeric',
            'precio' => 'nullable|numeric',
            'aumento_costos_anual' => 'nullable|numeric',
            'mano_obra_directa' => 'nullable|numeric',
            'mano_obra_destajo' => 'nullable|numeric',
            'aumento_anual_mod_destajo' => 'nullable|numeric',
            'pago_comision' => 'nullable|numeric',
            'servicios_publicos' => 'nullable|numeric',
            'inversion_maquinaria' => 'nullable|numeric',
            'inversion_muebles' => 'nullable|numeric',
            'inversion_vehiculos' => 'nullable|numeric',
            'inversion_tecnologia' => 'nullable|numeric',
            'porcentaje_aumento_gastos' => 'nullable|numeric',
            'tasa_oportunidad' => 'nullable|numeric',
        ]);

        $valoracion = Valoracion::create($data);
        return response()->json($valoracion, 201);
    }

    public function show($id)
    {
        $valoracion = Valoracion::with('proyecto')->findOrFail($id);
        return response()->json($valoracion);
    }

    public function update(Request $request, $id)
    {
        $valoracion = Valoracion::findOrFail($id);
        $valoracion->update($request->all());
        return response()->json($valoracion);
    }

    public function destroy($id)
    {
        $valoracion = Valoracion::findOrFail($id);
        $valoracion->delete();
        return response()->json(['message' => 'Valoración eliminada correctamente']);
    }

    public function datosEntrada()
    {
        return view('activosintangibles.valoracion.datos-entrada');
    }
}

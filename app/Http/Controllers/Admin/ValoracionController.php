<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Valoracion;
use App\Models\Tasa;

class ValoracionController extends Controller
{
    // Mostrar la vista de valoración por proyecto
    public function vista($proyectoId)
    {
        // Buscar la valoración asociada al proyecto
        $valoracion = Valoracion::where('FK_ID_Proyecto', $proyectoId)->first();

        // Si no existe, dejarlo en null (o new Valoracion() si prefieres objeto)
        if (!$valoracion) {
            $valoracion = null;
        }

        // Valores por defecto (garantizan que las variables existan)
        $valorProyectado  = 0;
        $activosTangibles = 0;
        $valorIntangibles = 0;

        if ($valoracion) {
            $valorProyectado  = ($valoracion->flujo_caja ?? 0) + ($valoracion->balance ?? 0);
            $activosTangibles = $valoracion->activos_tangibles ?? 0;
            $valorIntangibles = $valorProyectado + $activosTangibles;
        }

        return view('valoracion.index', compact(
            'valoracion',
            'valorProyectado',
            'activosTangibles',
            'valorIntangibles'
        ));
    }
}

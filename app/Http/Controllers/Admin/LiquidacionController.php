<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\Inversion2;
use App\Models\Usuario2;
use App\Models\Tasa;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LiquidacionController extends Controller
{
    /**
     * GET /api/liquidaciones?proyecto=ID&fecha_corte=YYYY-MM-DD
     * Devuelve resumen de liquidación (sin persistir cambios).
     */
    public function index(Request $request)
    {
        $proyectoId = (int) $request->query('proyecto');
        if (!$proyectoId) {
            return response()->json(['message' => 'Parámetro proyecto es requerido.'], 422);
        }

        $fechaCorte = $request->filled('fecha_corte')
            ? Carbon::parse($request->query('fecha_corte'))
            : Carbon::today();

        // Proyecto
        $proyecto = Proyecto::find($proyectoId);
        if (!$proyecto) {
            return response()->json(['message' => 'Proyecto no encontrado.'], 404);
        }

        // Última tasa
        $tasaRow = Tasa::orderByDesc('Id')->first();
        $tasa = $tasaRow ? (float) $tasaRow->Tasa : 0.0;
        $tasaDecimal = $tasa / 100.0;

        // Inversiones del proyecto
        $inversiones = Inversion2::with('usuario') // relacion usuario
            ->where('FK_ID_Proyecto', $proyectoId)
            ->orderBy('Fecha')
            ->get();

        $usuarios = [];
        $totalesPorTipo = [1 => 0, 2 => 0, 3 => 0];
        $totalAjustadoGlobal = 0;

        foreach ($inversiones as $inv) {
            $fechaInv = Carbon::parse($inv->Fecha);
            $dias = max(0, $fechaInv->diffInDays($fechaCorte));
            $valorFuturo = round($inv->Monto * pow(1 + $tasaDecimal, $dias / 365), 0);

            $uid = $inv->FK_ID_Usuario;
            if (!isset($usuarios[$uid])) {
                $usuarios[$uid] = [
                    'usuario_id' => $uid,
                    'nombre'     => trim(($inv->usuario->Nombre ?? '') . ' ' . ($inv->usuario->Apellido ?? '')),
                    'dinero'     => 0,
                    'especie'    => 0,
                    'industria'  => 0,
                    'total'      => 0,
                    'detalles'   => []
                ];
            }

            $claveTipo = match ((int)$inv->FK_ID_Tipo) {
                1 => 'dinero',
                2 => 'especie',
                3 => 'industria',
                default => 'otros',
            };

            $usuarios[$uid][$claveTipo] += $valorFuturo;
            $usuarios[$uid]['total']    += $valorFuturo;
            $totalesPorTipo[(int)$inv->FK_ID_Tipo] += $valorFuturo;
            $totalAjustadoGlobal += $valorFuturo;

            $usuarios[$uid]['detalles'][] = [
                'id'           => $inv->ID_Inversion,
                'tipo'         => (int)$inv->FK_ID_Tipo,
                'monto'        => (float)$inv->Monto,
                'fecha'        => (string)$inv->Fecha,
                'dias'         => $dias,
                'valor_futuro' => $valorFuturo,
                'descripcion'  => $inv->Descripcion,
            ];
        }

        $fechaProyecto = $proyecto->Fecha ? Carbon::parse($proyecto->Fecha) : null;
        $vidaDias = $fechaProyecto ? $fechaProyecto->diffInDays($fechaCorte) : 0;

        return response()->json([
            'proyecto' => [
                'id'         => $proyecto->ID_Proyecto,
                'nombre'     => $proyecto->Nombre,
                'fecha'      => $proyecto->Fecha,
                'liquidado'  => (int) ($proyecto->liquidado ?? 0),
            ],
            'tasa' => [
                'valor' => $tasa,
                'fuente' => $tasaRow?->Id,
            ],
            'fecha_corte' => $fechaCorte->toDateString(),
            'vida_proyecto_dias' => $vidaDias,
            'totales' => [
                'dinero'    => $totalesPorTipo[1] ?? 0,
                'especie'   => $totalesPorTipo[2] ?? 0,
                'industria' => $totalesPorTipo[3] ?? 0,
                'total'     => $totalAjustadoGlobal,
            ],
            'usuarios' => array_values($usuarios),
        ]);
    }

    /**
     * POST /api/proyectos/{proyecto}/liquidar
     */
    public function liquidar(Request $request, Proyecto $proyecto)
    {
        $request->validate([
            'documento_L' => 'required|file|mimes:pdf,zip,jpg,jpeg,png|max:10240',
        ]);

        if ((int)($proyecto->liquidado ?? 0) === 1) {
            return response()->json(['message' => 'El proyecto ya se encuentra liquidado.'], 409);
        }

        $file = $request->file('documento_L');
        $dir  = storage_path('app/certificados/liquidaciones');
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }

        $base = 'liquidacion-proyecto-' . $proyecto->ID_Proyecto . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), '-');
        $ext  = strtolower($file->getClientOriginalExtension());
        $name = $base . '.' . $ext;

        $i = 1;
        while (file_exists($dir . DIRECTORY_SEPARATOR . $name)) {
            $name = $base . '-' . $i . '.' . $ext;
            $i++;
        }

        $file->move($dir, $name);

        $proyecto->liquidado = 1;
        $proyecto->Certificado_L = $name;
        $proyecto->save();

        return response()->json([
            'message'  => 'Liquidación registrada exitosamente.',
            'proyecto' => $proyecto->fresh(),
            'archivo'  => $name,
        ], 200);
    }
}

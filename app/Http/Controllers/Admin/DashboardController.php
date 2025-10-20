<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Retorna la vista del dashboard
    public function index()
    {
        return view('admin.dashboard.index'); // Ajusta mayúsculas según carpeta
    }

    public function summary()
    {
        $totales = DB::table('proyecto')->selectRaw('COUNT(*) as total_proyectos')->first();
        $fechas  = DB::table('proyecto')
            ->selectRaw('MIN(Fecha) as fecha_mas_antigua, MAX(Fecha) as fecha_mas_nueva')
            ->first();
        $usuarios = DB::table('usuario2')->selectRaw('COUNT(*) as total_usuarios')->first();

        return response()->json([
            'total_proyectos'   => (int) ($totales->total_proyectos ?? 0),
            'fecha_mas_antigua' => $fechas->fecha_mas_antigua ?? null,
            'fecha_mas_nueva'   => $fechas->fecha_mas_nueva ?? null,
            'total_usuarios'    => (int) ($usuarios->total_usuarios ?? 0),
        ]);
    }

    public function proyectosPorMes(Request $r)
    {
        $year = (int) ($r->input('year') ?: date('Y'));

        $rows = DB::table('proyecto')
            ->selectRaw('MONTH(Fecha) as mes, COUNT(*) as total')
            ->whereYear('Fecha', $year)
            ->groupBy(DB::raw('MONTH(Fecha)'))
            ->pluck('total', 'mes');

        $series = [];
        for ($m = 1; $m <= 12; $m++) {
            $series[] = (int) ($rows[$m] ?? 0);
        }

        $labels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        return response()->json([
            'year'   => $year,
            'labels' => $labels,
            'series' => $series,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaisController extends Controller
{
    // Lista / Crear
    public function index()
    {
        return response()->json(Pais::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Nombre' => 'required|string|max:150|unique:paises,Nombre',
        ]);

        $pais = Pais::create($data);
        return response()->json($pais, 201);
    }

    // Mostrar
    public function show(Pais $pais)
    {
        return response()->json($pais);
    }

    // Actualizar
    public function update(Request $request, Pais $pais)
    {
        $data = $request->validate([
            'Nombre' => 'required|string|max:150|unique:paises,Nombre,' . $pais->ID_Pais . ',ID_Pais',
        ]);

        $pais->update($data);
        return response()->json(['message' => 'País actualizado', 'pais' => $pais->fresh()]);
    }

    // Eliminar
    public function destroy(Pais $pais)
    {
        $tieneDepartamentos = DB::table('departamento')
            ->where('FK_ID_Pais', $pais->ID_Pais)
            ->exists();

        if ($tieneDepartamentos) {
            return response()->json([
                'message' => 'No se puede eliminar el país porque tiene departamentos asociados.'
            ], 409);
        }

        $pais->delete();

        return response()->json([
            'message' => 'País eliminado exitosamente.',
            'id'      => $pais->ID_Pais,
        ]);
    }

    // Eliminar en lote
    public function destroyMany(Request $request)
    {
        $ids = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'numeric|exists:paises,ID_Pais',
        ])['ids'];

        $bloqueados = [];
        foreach ($ids as $id) {
            $tieneDepartamentos = DB::table('departamento')
                ->where('FK_ID_Pais', $id)
                ->exists();

            if ($tieneDepartamentos) {
                $bloqueados[] = $id;
                continue;
            }

            Pais::find($id)?->delete();
        }

        return response()->json([
            'message' => 'Proceso completado',
            'bloqueados' => $bloqueados,
        ]);
    }
}

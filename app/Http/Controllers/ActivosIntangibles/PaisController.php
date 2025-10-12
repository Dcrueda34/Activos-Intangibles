<?php

namespace App\Http\Controllers\ActivosIntangibles;

use App\Http\Controllers\Controller;
use App\Models\Pais;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    public function index(Request $r)
    {
        $data = $request->validate(['nombre' => 'required|string|max:150|unique:paises,nombre']);
        return response()->json(Pais::create($data), 201);
    }

    public function show(Pais $pais)
    {
        return $pais;
    }

    public function update(Request $request, Pais $pais)
    {
        $data = $request->validate(['nombre' => 'required|string|max:150|unique:paises,nombre,' . $pais->id]);
        $pais->update($data);
        return $pais->fresh();
    }

    public function destroy(Pais $pais)
    {
        $tieneDepartamentos = DB::table('departamento')
            ->where('FK_ID_Pais', $pais->ID_Pais)
            ->exists();

        if ($tieneDepartamentos) {
            return response()->json([
                'message' => 'No se puede eliminar el país porque tiene departamentos asociados.'
            ], 409); // Conflict
        }

        $id = $pais->ID_Pais;
        $pais->delete();

        return response()->json([
            'message' => 'País eliminado exitosamente.',
            'id'      => $id,
        ], 200);
    }

    /**
     * (Opcional) DELETE /api/paises  body: { "ids": [..] }
     * Elimina en lote los que NO tengan departamentos asociados; reporta bloqueados.
     */
    public function destroyMany(Request $r)
    {
        $data = $r->validate([
            'ID_Pais' => 'required|numeric|unique:pais,ID_Pais',
            'Nombre'  => 'required|string|max:200',
        ]);

        $pais = Pais::create($data);
        return response()->json($pais, 201);
    }

    public function update(Request $r, $id)
    {
        $pais = Pais::findOrFail($id);
        $data = $r->validate([
            'Nombre' => 'required|string|max:200',
        ]);
        $pais->update($data);
        return response()->json(['message' => 'País actualizado', 'pais' => $pais]);
    }

    public function destroy($id)
    {
        Pais::findOrFail($id)->delete();
        return response()->noContent();
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{
    public function index(Request $r)
    {
        $q = Ubicacion::query()->with([
            'pais:ID_Pais,nombre',
            'departamento:ID_Departamento,nombre,FK_ID_Pais',
            'municipio:ID_Municipio,nombre,FK_ID_Departamento'
        ]);

        if ($r->filled('pais_id')) $q->where('FK_ID_Pais', $r->pais_id);
        if ($r->filled('departamento_id')) $q->where('FK_ID_Departamento', $r->departamento_id);
        if ($r->filled('municipio_id')) $q->where('FK_ID_Municipio', $r->municipio_id);

        return $q->paginate(20);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'pais_id'         => 'required|exists:paises,ID_Pais',
            'departamento_id' => 'nullable|exists:departamento,ID_Departamento',
            'municipio_id'    => 'nullable|exists:municipio,ID_Municipio',
            'direccion'       => 'nullable|string|max:255',
        ]);

        return response()->json(Ubicacion::create($data), 201);
    }

    public function show(Ubicacion $ubicacion)
    {
        return $ubicacion->load(['pais', 'departamento', 'municipio']);
    }

    public function update(Request $r, Ubicacion $ubicacion)
    {
        $data = $r->validate([
            'pais_id'         => 'sometimes|exists:paises,ID_Pais',
            'departamento_id' => 'sometimes|nullable|exists:departamento,ID_Departamento',
            'municipio_id'    => 'sometimes|nullable|exists:municipio,ID_Municipio',
            'direccion'       => 'sometimes|nullable|string|max:255',
        ]);

        $ubicacion->update($data);
        return $ubicacion->fresh()->load(['pais', 'departamento', 'municipio']);
    }

    public function destroy(Ubicacion $ubicacion)
    {
        $ubicacion->delete();
        return response()->json(['message' => 'Ubicación eliminada', 'id' => $ubicacion->ID_Ubicacion]);
    }
}

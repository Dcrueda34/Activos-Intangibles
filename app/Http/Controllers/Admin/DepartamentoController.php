<?php

namespace App\Http\Controllers\ActivosIntangibles;

use App\Http\Controllers\Controller;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\Ciudad;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    // 🔹 Listar países o mostrar vista
    public function index(Request $r)
    {
        $q = Pais::query();

        if ($r->filled('search')) {
            $q->where('Nombre', 'like', '%' . $r->input('search') . '%');
        }

        if ($r->wantsJson()) {
            return $q->orderBy('Nombre')->get();
        }

        return view('ubicacion.index', [
            'paises' => $q->orderBy('Nombre')->get()
        ]);
    }

    // 🔹 Crear país
    public function store(Request $r)
    {
        $data = $r->validate([
            'ID_Pais' => 'required|numeric|unique:pais,ID_Pais',
            'Nombre'  => 'required|string|max:200',
        ]);

        $pais = Pais::create($data);
        return response()->json($pais, 201);
    }

    // 🔹 Actualizar país
    public function update(Request $r, $id)
    {
        $pais = Pais::findOrFail($id);
        $data = $r->validate([
            'Nombre' => 'required|string|max:200',
        ]);

        $pais->update($data);

        return response()->json([
            'message' => 'País actualizado correctamente',
            'pais' => $pais
        ]);
    }

    // 🔹 Eliminar país
    public function destroy($id)
    {
        Pais::findOrFail($id)->delete();
        return response()->json(['message' => 'País eliminado correctamente']);
    }

    // 🔹 Listar departamentos por país
    public function departamentos($idPais)
    {
        $departamentos = Departamento::where('FK_ID_Pais', $idPais)
            ->orderBy('Nombre')
            ->get();

        return response()->json($departamentos);
    }

    // 🔹 Listar ciudades por departamento
    public function ciudades($idDepartamento)
    {
        $ciudades = Ciudad::where('FK_ID_Departamento', $idDepartamento)
            ->orderBy('Nombre')
            ->get();

        return response()->json($ciudades);
    }
}

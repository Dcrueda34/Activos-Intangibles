<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pais;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    /**
     * Listar todos los países
     */
    public function index()
    {
        return response()->json(
            Pais::select('ID_Pais', 'Nombre')->orderBy('Nombre')->get()
        );
    }

    /**
     * Registrar nuevo país (opcional)
     */
    public function store(Request $request)
    {
        $request->validate(['Nombre' => 'required|string|max:100']);
        $pais = Pais::create($request->all());
        return response()->json($pais, 201);
    }

    /**
     * Mostrar un país específico
     */
    public function show($id)
    {
        $pais = Pais::findOrFail($id);
        return response()->json($pais);
    }

    /**
     * Actualizar un país
     */
    public function update(Request $request, $id)
    {
        $pais = Pais::findOrFail($id);
        $pais->update($request->all());
        return response()->json($pais);
    }

    /**
     * Eliminar un país
     */
    public function destroy($id)
    {
        $pais = Pais::findOrFail($id);
        $pais->delete();
        return response()->json(['message' => 'País eliminado correctamente']);
    }
}

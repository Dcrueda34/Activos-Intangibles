<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    /**
     * Listar departamentos, opcionalmente filtrados por país
     */
    public function index(Request $request)
    {
        $query = Departamento::query();

        if ($request->filled('pais')) {
            $query->where('FK_ID_Pais', $request->pais);
        }

        return response()->json(
            $query->orderBy('Nombre')->get()
        );
    }

    /**
     * Registrar un nuevo departamento
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:100',
            'FK_ID_Pais' => 'required|integer|exists:paises,ID_Pais',
        ]);

        $departamento = Departamento::create($request->all());
        return response()->json($departamento, 201);
    }

    /**
     * Mostrar un departamento
     */
    public function show($id)
    {
        $departamento = Departamento::findOrFail($id);
        return response()->json($departamento);
    }

    /**
     * Actualizar un departamento
     */
    public function update(Request $request, $id)
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->update($request->all());
        return response()->json($departamento);
    }

    /**
     * Eliminar un departamento
     */
    public function destroy($id)
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();
        return response()->json(['message' => 'Departamento eliminado correctamente']);
    }
}

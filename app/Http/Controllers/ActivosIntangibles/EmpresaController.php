<?php

namespace App\Http\Controllers\ActivosIntangibles;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        $q = Empresa::query();

        // 🔹 Filtro por búsqueda
        if ($request->filled('search')) {
            $q->where('Nombre', 'like', '%' . $request->search . '%');
        }

        // 🔹 Paginación
        $empresas = $q->paginate(20);

        // 🔹 Respuesta AJAX
        if ($request->ajax()) {
            // Renderizamos la parte que se va a actualizar
            $html = view('empresas.index', compact('empresas'))->render();
            return response()->json(['html' => $html]);
        }

        // 🔹 Vista normal
        return view('empresas.index', compact('empresas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'nit'    => 'nullable|string|max:100|unique:empresas,nit',
            'email'  => 'nullable|email|max:255',
        ]);

        $empresa = Empresa::create($data);
        return response()->json($empresa, 201);
    }

    public function show(Empresa $empresa)
    {
        return $empresa;
    }

    public function update(Request $request, Empresa $empresa)
    {
        $data = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'nit'    => 'sometimes|nullable|string|max:100|unique:empresas,nit,' . $empresa->id,
            'email'  => 'sometimes|nullable|email|max:255',
        ]);

        $empresa->update($data);
        return $empresa->fresh();
    }

    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return response()->noContent();
    }
}

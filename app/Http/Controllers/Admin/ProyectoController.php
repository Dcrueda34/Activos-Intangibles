<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function index(Request $request)
    {
        $query = Proyecto::query();

        // Filtrar por nombre
        if ($request->has('search') && $request->search != '') {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        // Filtrar por fecha desde/hasta
        if ($request->has('from') && $request->from != '') {
            $query->whereDate('fecha', '>=', $request->from);
        }
        if ($request->has('to') && $request->to != '') {
            $query->whereDate('fecha', '<=', $request->to);
        }

        // Ordenar
        $order_by = $request->order_by ?? 'ID_Proyecto';
        $order_dir = $request->order_dir ?? 'desc';
        $query->orderBy($order_by, $order_dir);

        // Paginación
        $proyectos = $query->paginate(10);

        return response()->json($proyectos);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha' => 'nullable|date',
            'descripcion' => 'nullable|string',
            'certificado' => 'nullable|file|mimes:pdf,zip,jpg,jpeg,png|max:2048',
            'liquidado' => 'nullable|boolean',
        ]);

        // Guardar archivo si viene
        if ($request->hasFile('certificado')) {
            $path = $request->file('certificado')->store('certificados', 'public');
            $data['certificado'] = $path;
        }

        $proyecto = \App\Models\Proyecto::create($data);

        return response()->json($proyecto, 201);
    }

    public function show(Proyecto $proyecto)
    {
        return $proyecto;
    }

    public function update(Request $request, Proyecto $proyecto)
    {
        $data = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'fecha' => 'sometimes|nullable|date',
            'descripcion' => 'sometimes|nullable|string',
            'certificado' => 'sometimes|nullable|string',
            'liquidado' => 'sometimes|boolean',
        ]);

        $proyecto->update($data);

        return $proyecto;
    }

    public function destroy(Proyecto $proyecto)
    {
        $proyecto->delete();
        return response()->noContent();
    }
}

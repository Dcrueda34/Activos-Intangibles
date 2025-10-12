<?php

namespace App\Http\Controllers\ActivosIntangibles;


use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function index()
    {
        return Proyecto::all();
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

<?php

namespace App\Http\Controllers\ActivosIntangibles;

use App\Http\Controllers\Controller;
use App\Models\Pais;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    public function index(Request $r)
    {
        $q = Departamento::query()->with('pais:id,Nombre');

        if ($r->filled('FK_ID_Pais')) {
            $q->where('FK_ID_Pais', $r->integer('FK_ID_Pais'));
        }

        if ($r->filled('search')) {
            $q->where('Nombre', 'like', '%'.$r->input('search').'%');
        }

        return $q->orderBy('Nombre')->paginate(20);
    }

        return view('ubicacion.index'); // la vista única
    }

    public function store(Request $r)
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
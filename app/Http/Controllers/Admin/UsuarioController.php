<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * LISTAR usuarios
     * GET /api/usuarios
     * Opcional: ?search=nombre
     */
    public function index(Request $request)
    {
        $query = Usuario2::query();

        if ($request->filled('search')) {
            $query->where('Nombre', 'like', '%' . $request->search . '%');
        }

        $usuarios = $query->paginate(10);

        return response()->json($usuarios);
    }

    /**
     * VER un usuario
     * GET /api/usuarios/{usuario}
     */
    public function show(Usuario2 $usuario)
    {
        return response()->json($usuario);
    }

    /**
     * CREAR usuario
     * POST /api/usuarios
     */
    public function store(Request $r)
    {
        $data = $r->validate([
            'Nombre'           => 'required|string|max:150',
            'Apellido'         => 'required|string|max:150',
            'Telefono'         => 'required|string|max:50',
            'Correo'           => 'required|string|email|max:190|unique:usuario2,Correo',
            'Contraseña'       => 'required|string|min:6|max:190',
            'FK_ID_Municipio'  => 'required|integer|exists:municipio,ID_Municipio',
        ]);

        $data['Contraseña'] = Hash::make($data['Contraseña']);

        $usuario = Usuario2::create($data);

        return response()->json([
            'message' => 'Usuario creado exitosamente.',
            'data' => $usuario
        ], 201);
    }

    /**
     * ACTUALIZAR usuario
     * PUT /api/usuarios/{usuario}
     */
    public function update(Request $r, Usuario2 $usuario)
    {
        $data = $r->validate([
            'Nombre'           => 'sometimes|required|string|max:150',
            'Apellido'         => 'sometimes|required|string|max:150',
            'Telefono'         => 'sometimes|required|string|max:50',
            'Correo'           => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:190',
                Rule::unique('usuario2', 'Correo')->ignore($usuario->ID_Usuario, 'ID_Usuario'),
            ],
            'Contraseña'       => 'nullable|string|min:6|max:190',
            'FK_ID_Municipio'  => 'sometimes|required|integer|exists:municipio,ID_Municipio',
        ]);

        if (!empty($data['Contraseña'])) {
            $data['Contraseña'] = Hash::make($data['Contraseña']);
        } else {
            unset($data['Contraseña']);
        }

        $usuario->update($data);

        return response()->json([
            'message' => 'Usuario actualizado exitosamente.',
            'data' => $usuario->fresh()
        ]);
    }

    /**
     * ELIMINAR usuario
     * DELETE /api/usuarios/{usuario}
     */
    public function destroy(Usuario2 $usuario)
    {
        $tieneVinculos = DB::table('proyecto_usuario')
            ->where('FK_ID_Usuario', $usuario->ID_Usuario)
            ->exists();

        if ($tieneVinculos) {
            return response()->json([
                'message' => 'El usuario no puede ser eliminado porque está vinculado a un proyecto/empresa.'
            ], 409);
        }

        $usuario->delete();

        return response()->json([
            'message' => 'Usuario eliminado exitosamente.',
            'id' => $usuario->ID_Usuario
        ]);
    }

    /**
     * ELIMINAR múltiples usuarios
     * DELETE /api/usuarios (body: { "ids": [1,2,3] })
     */
    public function destroyMany(Request $r)
    {
        $data = $r->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:usuario2,ID_Usuario',
        ]);

        $ids = $data['ids'];

        $vinculados = DB::table('proyecto_usuario')
            ->whereIn('FK_ID_Usuario', $ids)
            ->pluck('FK_ID_Usuario')
            ->unique()
            ->map(fn($v) => (int)$v)
            ->all();

        $eliminables = array_values(array_diff($ids, $vinculados));

        if (!empty($eliminables)) {
            DB::table('usuario2')->whereIn('ID_Usuario', $eliminables)->delete();
        }

        return response()->json([
            'eliminados' => $eliminables,
            'bloqueados' => $vinculados,
            'message' => 'Operación completada.'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // <-- IMPORTANTE
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    // PUT /api/usuarios/{usuario}
    public function update(Request $r, Usuario $usuario)
    {
        $data = $r->validate([
            'Nombre'           => 'required|string|max:150',
            'Apellido'         => 'required|string|max:150',
            'Telefono'         => 'required|string|max:50',
            'Correo'           => [
                'required',
                'string',
                'email',
                'max:190',
                Rule::unique('usuario2', 'Correo')->ignore($usuario->getKey(), $usuario->getKeyName()),
            ],
            'Contraseña'       => 'nullable|string|min:6|max:190',
            'FK_ID_Municipio'  => 'required|integer|exists:municipio,ID_Municipio',
        ]);

        $usuario->Nombre          = $data['Nombre'];
        $usuario->Apellido        = $data['Apellido'];
        $usuario->Telefono        = $data['Telefono'];
        $usuario->Correo          = $data['Correo'];
        $usuario->FK_ID_Municipio = $data['FK_ID_Municipio'];

        if (!empty($data['Contraseña'])) {
            $usuario->{'Contraseña'} = Hash::make($data['Contraseña']);
        }

        $usuario->save();

        return response()->json([
            'message' => 'Usuario actualizado exitosamente.',
            'data'    => $usuario->fresh(),
        ], 200);
    }

    // POST /api/usuarios/update-legacy
    public function updateLegacy(Request $r)
    {
        $data = $r->validate([
            'id_usuario'        => 'required|integer|exists:usuario2,ID_Usuario',
            'nombre_usuario'    => 'required|string|max:150',
            'apellido_usuario'  => 'required|string|max:150',
            'telefono_usuario'  => 'required|string|max:50',
            'correo_usuario'    => [
                'required',
                'string',
                'email',
                'max:190',
                Rule::unique('usuario2', 'Correo')->ignore($r->integer('id_usuario'), 'ID_Usuario'),
            ],
            'contraseña_usuario' => 'nullable|string|min:6|max:190',
            'municipio_usuario'  => 'required|integer|exists:municipio,ID_Municipio',
        ]);

        $usuario = Usuario::findOrFail($data['id_usuario']);
        $usuario->Nombre          = $data['nombre_usuario'];
        $usuario->Apellido        = $data['apellido_usuario'];
        $usuario->Telefono        = $data['telefono_usuario'];
        $usuario->Correo          = $data['correo_usuario'];
        $usuario->FK_ID_Municipio = $data['municipio_usuario'];

        if (!empty($data['contraseña_usuario'])) {
            $usuario->{'Contraseña'} = Hash::make($data['contraseña_usuario']);
        }

        $usuario->save();

        return response()->json([
            'message' => 'Usuario actualizado exitosamente.',
            'data'    => $usuario,
        ]);
    }

    public function destroy(Usuario $usuario)
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
            'id' => $usuario->ID_Usuario,
        ], 200);
    }

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
            'eliminados'  => $eliminables,
            'bloqueados'  => $vinculados,
            'message'     => 'Operación completada.',
        ]);
    }
}

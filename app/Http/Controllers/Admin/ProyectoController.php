<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ProyectoController extends Controller
{
    /**
     * 📄 Listar proyectos con filtros, orden y paginación
     */
    public function index(Request $request)
    {
        $query = Proyecto::query();

        // 🔍 Filtros
        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('from')) {
            $query->whereDate('fecha', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('fecha', '<=', $request->to);
        }

        // 🧭 Ordenar resultados
        $order_by = $request->order_by ?? 'ID_Proyecto';
        $order_dir = $request->order_dir ?? 'desc';
        $query->orderBy($order_by, $order_dir);

        // 📄 Paginación
        $proyectos = $query->paginate(10);

        return response()->json($proyectos);
    }

    /**
     * 💾 Crear un nuevo proyecto
     */
    public function store(Request $request)
    {
        try {
            Log::info('📥 Datos recibidos para guardar proyecto:', $request->all());

            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'fecha' => 'required|date',
                'descripcion' => 'nullable|string',
                'certificado' => 'nullable|file|mimes:pdf,zip,jpg,jpeg,png|max:10240',
                'liquidado' => 'nullable|boolean',
            ]);

            // 📎 Guardar archivo si se envía
            if ($request->hasFile('certificado')) {
                $path = $request->file('certificado')->store('certificados', 'public');
                $validated['certificado'] = $path;
            }

            // ✅ Crear el proyecto en la BD
            $proyecto = Proyecto::create([
                'nombre' => $validated['nombre'],
                'fecha' => $validated['fecha'],
                'descripcion' => $validated['descripcion'] ?? null,
                'certificado' => $validated['certificado'] ?? null,
                'liquidado' => $validated['liquidado'] ?? 0,
            ]);

            Log::info('✅ Proyecto creado correctamente:', $proyecto->toArray());

            return response()->json([
                'message' => 'Proyecto creado correctamente',
                'data' => $proyecto
            ], 201);
        } catch (\Exception $e) {
            Log::error('💥 Error al guardar proyecto:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error al guardar proyecto', 'detalle' => $e->getMessage()], 500);
        }
    }

    /**
     * 👁️ Mostrar un proyecto específico
     */
    public function show($id)
    {
        try {
            $proyecto = Proyecto::findOrFail($id);

            if ($proyecto->certificado) {
                $proyecto->certificado_url = asset('storage/' . $proyecto->certificado);
            }

            return response()->json([
                'message' => 'Proyecto encontrado correctamente',
                'data' => $proyecto
            ]);

            $proyecto->url_descarga = url("/api/proyectos/{$proyecto->ID_Proyecto}/descargar-certificado");
        } catch (\Exception $e) {
            Log::error('💥 Error al mostrar proyecto:', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error al obtener el proyecto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✏️ Actualizar un proyecto existente
     */
    public function update(Request $request, $id)
    {
        $proyecto = Proyecto::findOrFail($id);

        Log::info('✏️ Datos recibidos para actualizar proyecto:', $request->all());

        $data = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'fecha' => 'sometimes|nullable|date',
            'descripcion' => 'sometimes|nullable|string',
            'certificado' => 'sometimes|nullable|file|mimes:pdf,zip,jpg,jpeg,png|max:10240',
            'liquidado' => 'sometimes|boolean',
        ]);

        if ($request->hasFile('certificado')) {
            if ($proyecto->certificado && Storage::disk('public')->exists($proyecto->certificado)) {
                Storage::disk('public')->delete($proyecto->certificado);
            }

            $rutaArchivo = $request->file('certificado')->store('certificados', 'public');
            $data['certificado'] = $rutaArchivo;
        }

        try {
            $proyecto->update($data);

            Log::info('✅ Proyecto actualizado correctamente:', ['id' => $proyecto->ID_Proyecto]);

            return response()->json([
                'message' => 'Proyecto actualizado correctamente',
                'data' => $proyecto
            ]);
        } catch (\Exception $e) {
            Log::error('💥 Error al actualizar proyecto:', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error al actualizar el proyecto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 🗑️ Eliminar proyecto
     */
    public function destroy($id)
    {
        try {
            $proyecto = Proyecto::findOrFail($id);

            if ($proyecto->certificado && Storage::disk('public')->exists($proyecto->certificado)) {
                Storage::disk('public')->delete($proyecto->certificado);
            }

            $proyecto->delete();

            Log::info('🗑️ Proyecto eliminado:', ['id' => $id]);

            return response()->json(['message' => 'Proyecto eliminado correctamente']);
        } catch (\Exception $e) {
            Log::error('💥 Error al eliminar proyecto:', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error al eliminar el proyecto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 🔽 Listado simple para selects
     */
    public function select()
    {
        $proyectos = Proyecto::select('ID_Proyecto', 'nombre')
            ->orderBy('nombre')
            ->get();

        return response()->json($proyectos);
    }

    public function descargarCertificado($id)
    {
        try {
            $proyecto = Proyecto::findOrFail($id);

            if (!$proyecto->certificado || !Storage::disk('public')->exists($proyecto->certificado)) {
                return response()->json(['error' => 'El certificado no existe o fue eliminado.'], 404);
            }

            $path = Storage::disk('public')->path($proyecto->certificado);
            $nombreArchivo = basename($path);

            return response()->download($path, $nombreArchivo);
        } catch (\Exception $e) {
            Log::error('💥 Error al descargar certificado:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error al descargar el certificado.'], 500);
        }
    }
}

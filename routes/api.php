<?php

use Illuminate\Support\Facades\Route;



// ===== Controladores Admin =====
use App\Http\Controllers\Admin\{
    AdminController,
    ConsultaController,
    DescargaController,
    DashboardController,
    EmpresaController,
    InversionController,
    LiquidacionController,
    MunicipioController,
    PaisController,
    ProyectoController,
    SimulacionController,
    TipoInversionController,
    TasaController,
    UbicacionController,
    UsuarioController,
    VinculacionController,
    DepartamentoController, // ⚠️ Verificar que exista
    CatalogoUbicacionController,
    ValoracionController
};

// ===== Controladores Inversionista =====
use App\Http\Controllers\Inversionista\{
    DashboardController as InvDash,
    LiquidacionController as InvLiquidacion,
    ReporteController,
    ReporteInversionesController
};

// =====================================================
// RUTA DE PRUEBA
// =====================================================
Route::get('/test', fn() => response()->json(['status' => 'API funcionando ✅']));

// =====================================================
// RUTAS ADMIN - CRUD PRINCIPALES
// =====================================================

// Usuarios
Route::apiResource('usuarios', UsuarioController::class);
Route::post('usuarios/update-legacy', [UsuarioController::class, 'updateLegacy']);

// Empresas
Route::apiResource('empresas', EmpresaController::class);

// Proyectos
Route::apiResource('proyectos', ProyectoController::class)->only(['index', 'store', 'update', 'destroy']);
Route::get('proyectos/select', [ProyectoController::class, 'select'])->name('api.proyectos.select');
Route::post('proyectos/{proyecto}/liquidar', [ProyectoController::class, 'liquidar']);
Route::post('proyectos/{proyecto}/simular', [ProyectoController::class, 'simular']);
Route::delete('proyectos', [ProyectoController::class, 'destroyMany']);
Route::post('/proyectos', [ProyectoController::class, 'store']);
Route::get('/proyectos/{id}/descargar-certificado', [ProyectoController::class, 'descargarCertificado']);

// Inversiones
Route::delete('inversiones', [InversionController::class, 'destroyMany']);
Route::get('inversiones/index-view', [InversionController::class, 'indexView'])->name('inversiones.index');

// Países / Departamentos / Municipios
Route::apiResource('paises', PaisController::class);
Route::apiResource('departamentos', DepartamentoController::class); // ⚠️ Verificar existencia
Route::apiResource('municipios', MunicipioController::class);
Route::post('municipios/update-legacy', [MunicipioController::class, 'updateLegacy']);
Route::post('paises/update-legacy', [PaisController::class, 'updateLegacy']);

// Tipos de inversión
Route::apiResource('tipos-inversion', TipoInversionController::class);

// Tasas
Route::apiResource('tasas', TasaController::class);
Route::get('tasas/ultima', [TasaController::class, 'ultima']);
Route::get('/tasas/ultima', [ValoracionController::class, 'ultima']);
Route::get('/valoracion', [ValoracionController::class, 'vista'])
    ->name('valoracion.vista');


// Ubicaciones
Route::apiResource('ubicaciones', UbicacionController::class);
// Trae todos los países
Route::get('ubicacion/paises', [PaisController::class, 'index']);

// Trae departamentos según país
Route::get('ubicacion/departamentos/{paisId}', [PaisController::class, 'departamentos']);

// Trae municipios según departamento
Route::get('ubicacion/municipios/{departamentoId}', [PaisController::class, 'municipios']);

// Trae ciudades según municipio
Route::get('ubicacion/ciudades/{municipioId}', [PaisController::class, 'ciudades']);


// Liquidaciones
Route::apiResource('liquidaciones', LiquidacionController::class);

// Simulaciones
Route::apiResource('simulaciones', SimulacionController::class);
Route::get('simulacion/resumen', [SimulacionController::class, 'resumen']);

// Valoraciones
Route::post('/guardar', [ValoracionController::class, 'store'])->name('valoracion.datos_entrada');
Route::get('/valoracion', [ValoracionController::class, 'index'])->name('valoracion.index');
Route::get('/valoracion/{proyectoId}', [ValoracionController::class, 'vista'])->name('valoracion.vista');


// Vinculaciones
Route::get('vinculaciones', [VinculacionController::class, 'index']);
Route::post('vinculaciones', [VinculacionController::class, 'store']);
Route::delete('vinculaciones', [VinculacionController::class, 'destroy']);

// Dashboard
Route::get('dashboard/summary', [DashboardController::class, 'summary']);
Route::get('dashboard/proyectos-por-mes', [DashboardController::class, 'proyectosPorMes']);

// Consultas y catálogos
Route::get('consultas/usuarios', [ConsultaController::class, 'usuarios']);
Route::get('consultas/proyectos-por-usuario/{usuario}', [ConsultaController::class, 'proyectosPorUsuario']);
Route::get('consultas/resumen', [ConsultaController::class, 'resumen']);
Route::get('consultas/busqueda', [ConsultaController::class, 'busqueda']);
Route::get('catalogos/proyectos-no-liquidados', [ConsultaController::class, 'proyectosNoLiquidados']);
Route::get('catalogos/usuarios-para-vincular', [ConsultaController::class, 'usuariosParaVincular']);
Route::prefix('ubicacion')->group(function () {
    Route::get('paises', [CatalogoUbicacionController::class, 'getPaises']);
    Route::get('departamentos/{paisId}', [CatalogoUbicacionController::class, 'getDepartamentos']);
    Route::get('municipios/{departamentoId}', [CatalogoUbicacionController::class, 'getMunicipios']);
});
// Descargas
Route::get('descargas/{recurso}/{id}/certificado', [DescargaController::class, 'certificado'])
    ->whereIn('recurso', ['inversiones', 'proyectos']);
Route::get('descargas/proyectos-liquidacion/{id}', [DescargaController::class, 'certificado'])
    ->defaults('recurso', 'proyectos-liquidacion');
Route::get('descargas/inversiones', [DescargaController::class, 'inversiones'])->name('descargas.inversiones');
Route::get('descargas/proyectos', [DescargaController::class, 'proyectos'])->name('descargas.proyectos');

// =====================================================
// RUTAS INVERSIONISTA
// =====================================================
Route::prefix('inversionista')->group(function () {
    Route::get('dashboard', [InvDash::class, 'index']);
    Route::apiResource('liquidaciones', InvLiquidacion::class);
    Route::get('reportes', [ReporteController::class, 'index']);
    Route::get('reportes/inversiones', [ReporteInversionesController::class, 'index']);
});

// =====================================================
// FALLBACK 404 JSON
// =====================================================
Route::fallback(function () {
    return response()->json([
        'message' => '❌ Ruta no encontrada. Verifica la URL y el método HTTP.'
    ], 404);
});

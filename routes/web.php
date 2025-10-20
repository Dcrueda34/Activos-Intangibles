<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ValoracionController;
use App\Http\Controllers\Admin\EmpresaController;
use App\Http\Controllers\Admin\PresupuestoController;
use App\Http\Controllers\Moderador\UsuarioController;
use App\Http\Controllers\Moderador\InversionController;
use App\Http\Controllers\Moderador\InversionDocumentoController;
use App\Http\Controllers\Moderador\HomeController;
use App\Http\Controllers\Moderador\EstadisticasController;
use App\Http\Controllers\Moderador\ConsultasController;
use App\Http\Controllers\Proyecto\ProjectSelectionController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\NotasController;
use App\Http\Controllers\Auth\LogoutController;



// ===================== Vistas Blade =====================
Route::view('/dashboard', 'admin.dashboard.index')->name('dashboard');
Route::view('/inicio', 'admin.dashboard.index')->name('inicio');
Route::view('/empresas', 'admin.empresas.index')->name('empresas');
Route::view('/inversiones', 'inversiones.index')->name('inversiones.index');
Route::view('/simulacion', 'simulacion.index')->name('simulacion.index');
Route::view('/liquidacion', 'liquidacion.index')->name('liquidacion.index');
Route::view('/liquidar-proyecto', 'liquidar-proyecto.index')->name('liquidar-proyecto.index');
Route::view('/registro', 'registro.index')->name('registro.index');
Route::view('/consultas', 'consultas.index')->name('consultas.index');
Route::view('/tipos-inversion', 'tipos-inversion.index')->name('tipos-inversion.index');
Route::view('/ubicacion', 'admin.ubicacion.index')->name('ubicacion.index');
Route::view('/usuarios', 'usuarios.index')->name('usuarios.index');
Route::view('/valoracion', 'valoracion.index')->name('valoracion.index');
// Ruta para ver la valoración de un proyecto
// Ruta para mostrar la valoración del proyecto

Route::get('/valoracion/{proyectoId}', [ValoracionController::class, 'vista'])
    ->name('valoracion.vista');


Route::get('/presupuesto/vista', [PresupuestoController::class, 'vista'])->name('presupuesto.vista');

Route::get('/presupuesto/ingresar', [PresupuestoController::class, 'ingresar'])
    ->name('presupuesto.ingresar');

//Route::get('/valoracion', [ValoracionController::class, 'index'])->name('valoracion.index');


Route::view('/tasas', 'tasas.index')->name('tasas.vista');

// ===================== Rutas Moderador =====================
Route::prefix('moderador')->middleware('auth')->name('moderador.')->group(function () {
    // Usuarios
    Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');

    // Inversiones
    Route::get('/inversiones', [InversionController::class, 'index'])->name('inversiones.index');
    Route::post('/inversiones', [InversionController::class, 'store'])->name('inversiones.store');


    // Inversiones con documentos
    Route::get('inversiones/registrar', [InversionDocumentoController::class, 'create'])->name('inversiones.docs.create');
    Route::post('inversiones/registrar', [InversionDocumentoController::class, 'store'])->name('inversiones.docs.store');
    Route::get('inversiones/docs', [InversionDocumentoController::class, 'index'])->name('inversiones.docs.index');

    // Dashboard Home
    Route::get('/', [HomeController::class, 'index'])->name('inicio');

    // Estadísticas y consultas
    Route::get('estadisticas/datos-line', [EstadisticasController::class, 'datosLine'])->name('estadisticas.datos-line');
    Route::get('consultas', [ConsultasController::class, 'index'])->name('consultas.index');
    Route::post('consultas', [ConsultasController::class, 'consultar'])->name('consultas.consultar');
    Route::get('consultas/proyectos', [ConsultasController::class, 'proyectosPorUsuario'])->name('consultas.proyectos-usuario');

    // Proyectos selección
    Route::get('/proyectos/elegir', [ProjectSelectionController::class, 'create'])->name('proyectos.elegir');
    Route::post('/proyectos/seleccionar', [ProjectSelectionController::class, 'store'])->name('proyectos.seleccionar');

    // Mantenimiento y notas
    Route::get('/mantenimiento', [MaintenanceController::class, 'show'])->name('mantenimiento');
    Route::get('/notas', [NotasController::class, 'create'])->name('notas.create');
    Route::post('/notas', [NotasController::class, 'store'])->name('notas.store');
});

// ===================== Auth y Logout =====================
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/cerrar-sesion', [LogoutController::class, 'legacy'])->name('logout.legacy');

// ===================== Redirección por defecto =====================
Route::redirect('/', '/dashboard');

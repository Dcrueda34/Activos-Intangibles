@extends('admin.layouts.app')

@section('title','Presupuesto')
@section('page-title','Presupuesto General')

@section('content')
<div class="container-fluid py-3">

  <!-- Tabs principales de Presupuesto -->
  <ul class="nav nav-tabs mb-4" id="presupuestoTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="tab-operacion" data-bs-toggle="tab" data-bs-target="#operacion" type="button" role="tab">Presupuesto de Operación</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="tab-financiero" data-bs-toggle="tab" data-bs-target="#financiero" type="button" role="tab">Presupuesto Financiero</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="tab-inversiones" data-bs-toggle="tab" data-bs-target="#inversiones" type="button" role="tab">Presupuesto de Inversiones de Capital</button>
    </li>
  </ul>

  <div class="tab-content" id="presupuestoTabsContent">

    <!-- Presupuesto de Operación -->
    <div class="tab-pane fade show active" id="operacion" role="tabpanel">
       @include('valoracion.partials.presupuestoOperacion')
    </div>

    <!-- Presupuesto Financiero -->
    <div class="tab-pane fade" id="financiero" role="tabpanel">
      <p class="text-muted">Aquí se mostrará la tabla de Presupuesto Financiero (pendiente de construir).</p>
    </div>

    <!-- Presupuesto de Inversiones de Capital -->
    <div class="tab-pane fade" id="inversiones" role="tabpanel">
      <p class="text-muted">Aquí se mostrará la tabla de Presupuesto de Inversiones de Capital (pendiente de construir).</p>
    </div>

  </div>

  <!-- Botón de ingreso de datos -->
  <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <h5 class="mb-0">Detalles del Presupuesto</h5>
    <a href="{{ route('presupuesto.ingresar') }}" class="btn btn-primary">
      <i class="bi bi-pencil-square me-1"></i> Ingresar Datos
    </a>
  </div>

</div>
@endsection

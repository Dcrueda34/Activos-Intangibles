@extends('admin.layouts.app')

@section('title','Valoración Activos Intangibles')
@section('page-title','Valoración de Activos Intangibles')

@section('content')
<div class="container-fluid py-3">

  <!-- Tabs principales -->
  <ul class="nav nav-tabs mb-4" id="mainTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="tab-datos" data-bs-toggle="tab" data-bs-target="#datosEntrada" type="button" role="tab">Datos de Entrada</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="tab-valoracion" data-bs-toggle="tab" data-bs-target="#valoracion" type="button" role="tab">Valoración Activos Intangibles</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="tab-presupuesto" data-bs-toggle="tab" data-bs-target="#presupuesto" type="button" role="tab">Presupuesto de Inversión</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="tab-objetivo" data-bs-toggle="tab" data-bs-target="#objetivo" type="button" role="tab">Objetivo Valoración</button>
    </li>
  </ul>

  <div class="tab-content" id="mainTabsContent">

    <!-- 🧾 Datos de Entrada -->
    <div class="tab-pane fade show active" id="datosEntrada" role="tabpanel" aria-labelledby="tab-datos">

      <!-- Sub-tabs dentro de Datos de Entrada -->
      <ul class="nav nav-pills mb-3" id="subTabsDatos" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="infoGeneral-tab" data-bs-toggle="pill" data-bs-target="#infoGeneral" type="button" role="tab">Información General</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="marketing-tab" data-bs-toggle="pill" data-bs-target="#marketing" type="button" role="tab">Marketing y Publicidad</button>
        </li>
      </ul>

      <div class="tab-content" id="subTabsDatosContent">

        <!-- Información General -->
        <div class="tab-pane fade show active" id="infoGeneral" role="tabpanel">
          @include('valoracion.partials.datos_entrada')
        </div>

        <!-- Marketing y Publicidad -->
        <div class="tab-pane fade" id="marketing" role="tabpanel">
          @include('valoracion.partials.marketing')
        </div>
      </div>
    </div>

    <!-- 💰 Valoración activos intangibles -->
    <div class="tab-pane fade" id="valoracion" role="tabpanel">
        @include('valoracion.partials.activos_intangibles')
    </div>

    <!-- 💵 Presupuesto con subpestañas -->
    <div class="tab-pane fade" id="presupuesto" role="tabpanel">

      <!-- Subpestañas de Presupuesto -->
      <ul class="nav nav-pills mb-3" id="subTabsPresupuesto" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="operacion-tab" data-bs-toggle="pill" data-bs-target="#operacion" type="button" role="tab">Presupuesto de Operación</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="financiero-tab" data-bs-toggle="pill" data-bs-target="#financiero" type="button" role="tab">Presupuesto Financiero</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="inversiones-tab" data-bs-toggle="pill" data-bs-target="#inversiones" type="button" role="tab">Presupuesto de Inversiones</button>
        </li>
      </ul>

      <div class="tab-content" id="subTabsPresupuestoContent">
        <div class="tab-pane fade show active" id="operacion" role="tabpanel">
       <p class="text-muted">Aquí irá presupuesto de financiero (pendiente de construir).</p>
        </div>
        <div class="tab-pane fade" id="financiero" role="tabpanel">
          <p class="text-muted">Aquí irá presupuesto de financiero (pendiente de construir).</p>
        </div>
        <div class="tab-pane fade" id="inversiones" role="tabpanel">
         <p class="text-muted">Aquí irá presupuesto de Inversiones(pendiente de construir).</p>
        </div>
      </div>
    </div>

    <!-- 🎯 Objetivo -->
    <div class="tab-pane fade" id="objetivo" role="tabpanel">
      <p class="text-muted">Aquí irá el objetivo de valoración (pendiente de construir).</p>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">

  <h5 class="mb-0">Valoraciones</h5>
  <a href="{{ route('valoracion.datos_entrada') }}" class="btn btn-primary">
    <i class="bi bi-pencil-square me-1"></i> Ingresar Datos
  </a>
</div>

  </div>
</div>
@endsection

<div class="card shadow-sm mb-4">
  <div class="card-header bg-secondary text-white">
    <h6 class="mb-0">Presupuesto de Operación</h6>
  </div>
  <div class="card-body">
    <ul class="nav nav-tabs mb-3" id="tabsOperacion" role="tablist">
      <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#opVentas" type="button">Ventas</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#opCostos" type="button">Costos de Producción</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#opAdmin" type="button">Administración</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#opMercadeo" type="button">Mercadeo y Publicidad</button></li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane fade show active" id="opVentas" role="tabpanel">
        @include('valoracion.partials.presupuesto.costos')
      </div>
      <div class="tab-pane fade" id="opCostos" role="tabpanel">
        @include('valoracion.partials.presupuesto.costos')
      </div>
      <div class="tab-pane fade" id="opAdmin" role="tabpanel">
        @include('valoracion.partials.presupuesto.administracion')
      </div>
      <div class="tab-pane fade" id="opMercadeo" role="tabpanel">
        @include('valoracion.partials.presupuesto.mercadeo')
      </div>
    </div>
  </div>
</div>

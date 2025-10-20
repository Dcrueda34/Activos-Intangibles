<!-- 🧾 Sub-tabs dentro de Presupuesto de Operación -->
<ul class="nav nav-pills mb-3" id="subTabsOperacion" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="ventas-tab" data-bs-toggle="pill" data-bs-target="#ventas" type="button"
            role="tab">
            Presupuesto de Ventas
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="costos-tab" data-bs-toggle="pill" data-bs-target="#costos" type="button"
            role="tab">
            Presupuesto de Costos de Producción
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="admin-tab" data-bs-toggle="pill" data-bs-target="#admin" type="button" role="tab">
            Presupuesto de Gastos de Administración
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="marketing-tab" data-bs-toggle="pill" data-bs-target="#marketingOperacion"
            type="button" role="tab">
            Presupuesto de Mercadeo y Publicidad
        </button>
    </li>
</ul>

<div class="tab-content" id="subTabsOperacionContent">

    <!-- 📊 Ventas -->
    <div class="tab-pane fade show active" id="ventas" role="tabpanel">
        @include('valoracion.presupuesto.operacion.ventas')
    </div>

    <!-- ⚙️ Costos de Producción -->
    <div class="tab-pane fade" id="costos" role="tabpanel">
        @include('valoracion.presupuesto.operacion.costos')
    </div>

    <!-- 🏢 Gastos de Administración -->
    <div class="tab-pane fade" id="admin" role="tabpanel">
        @include('valoracion.presupuesto.operacion.administracion')
    </div>

    <!-- 📢 Mercadeo y Publicidad -->
    <div class="tab-pane fade" id="marketingOperacion" role="tabpanel">
        @include('valoracion.presupuesto.operacion.marketing')
    </div>

</div>

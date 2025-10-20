<div class="card shadow-sm mb-4">
    <div class="card-header bg-secondary text-white">
        <h6 class="mb-0">Presupuesto</h6>
    </div>

    <div class="card-body">

        <!-- 🗂 Tabs principales del Presupuesto -->
        <ul class="nav nav-tabs mb-4" id="presupuestoTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="operacion-tab" data-bs-toggle="tab" data-bs-target="#operacion"
                    type="button" role="tab">Presupuesto de Operación</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="financiero-tab" data-bs-toggle="tab" data-bs-target="#financiero"
                    type="button" role="tab">Presupuesto Financiero</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="inversion-tab" data-bs-toggle="tab" data-bs-target="#inversion"
                    type="button" role="tab">Presupuesto de Inversiones de Capital</button>
            </li>
        </ul>

        <div class="tab-content" id="presupuestoTabsContent">

            <!-- 💼 Presupuesto de Operación -->
            <div class="tab-pane fade show active" id="operacion" role="tabpanel">
                <ul class="nav nav-pills mb-3" id="operacionSubTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="ventas-tab" data-bs-toggle="pill" data-bs-target="#ventas"
                            type="button" role="tab">Presupuesto de Ventas</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="costos-produccion-tab" data-bs-toggle="pill"
                            data-bs-target="#costosProduccion" type="button" role="tab">Presupuesto Costos de
                            Producción</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="gastos-admin-tab" data-bs-toggle="pill"
                            data-bs-target="#gastosAdmin" type="button" role="tab">Gastos de Administración</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="mercadeo-tab" data-bs-toggle="pill" data-bs-target="#mercadeo"
                            type="button" role="tab">Mercadeo y Publicidad</button>
                    </li>
                </ul>

                <div class="tab-content" id="operacionSubTabsContent">
                    <!-- Presupuesto de Ventas -->
                    <div class="tab-pane fade show active" id="ventas" role="tabpanel">
                        <p class="text-muted">Aquí se muestran los datos de presupuesto de ventas según los datos de
                            entrada.</p>
                        <pre>{{ print_r($datosEntrada->ventas ?? [], true) }}</pre>
                    </div>

                    <!-- Presupuesto Costos de Producción -->
                    <div class="tab-pane fade" id="costosProduccion" role="tabpanel">
                        <p class="text-muted">Subdivisiones:</p>
                        <ul>
                            <li>Compras:
                                <pre>{{ print_r($compras, true) }}</pre>
                            </li>
                            <li>Mano de Obra:
                                <pre>{{ print_r($mo, true) }}</pre>
                            </li>
                            <li>CIF:
                                <pre>{{ print_r($cif, true) }}</pre>
                            </li>
                        </ul>
                    </div>

                    <!-- Presupuesto Gastos de Administración -->
                    <div class="tab-pane fade" id="gastosAdmin" role="tabpanel">
                        <pre>{{ print_r($admin, true) }}</pre>
                    </div>

                    <!-- Presupuesto Mercadeo y Publicidad -->
                    <div class="tab-pane fade" id="mercadeo" role="tabpanel">
                        <pre>{{ print_r($mercadeo, true) }}</pre>
                    </div>
                </div>
            </div>

            <!-- 💰 Presupuesto Financiero -->
            <div class="tab-pane fade" id="financiero" role="tabpanel">
                <p class="text-muted">Aquí se mostrarán los datos de presupuesto financiero según los datos de entrada.
                </p>
            </div>

            <!-- 💵 Presupuesto de Inversiones de Capital -->
            <div class="tab-pane fade" id="inversion" role="tabpanel">
                <pre>{{ print_r($inversiones, true) }}</pre>
            </div>

        </div>
    </div>
</div>
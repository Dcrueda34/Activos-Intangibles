<div class="card shadow-sm mb-4">
  <div class="card-header bg-primary text-white">
    <h6 class="mb-0">Datos de Entrada</h6>
  </div>

  <div class="card shadow-sm mb-4">
    <div class="card-header bg-warning text-center text-dark fw-bold">
      NOMBRE DEL PRODUCTO, CANTIDAD Y PRECIO
    </div>
    <div class="card-body">

      <!-- Selección de cantidad de productos -->
      <div class="mb-3">
        <label for="cantidad_productos" class="form-label fw-semibold">Cantidad de productos</label>
        <input type="number" id="cantidad_productos" class="form-control" min="1" max="20" value="1">
      </div>

      <!-- Tabla dinámica -->
      <form id="productos_form">
        <div id="productos_container" class="table-responsive">
          <table class="table table-bordered align-middle text-center">
            <thead class="table-warning">
              <tr>
                <th style="width: 35%">NOMBRE DEL PRODUCTO</th>
                <th style="width: 20%">CANTIDAD A VENDER</th>
                <th style="width: 20%">PRECIO UNITARIO ($)</th>
                <th style="width: 20%">TOTAL ($)</th>
              </tr>
            </thead>
            <tbody id="productos_table_body">
              <tr>
                <td><input type="text" class="form-control nombre_producto" name="nombre_producto[]" placeholder="Ej: Restaurante"></td>
                <td><input type="number" class="form-control cantidad" name="cantidad_vender[]" min="0" placeholder="0"></td>
                <td><input type="number" class="form-control precio" name="precio[]" step="0.01" placeholder="$0.00"></td>
                <td><input type="text" class="form-control total" name="total[]" readonly value="$0.00"></td>
              </tr>
            </tbody>
            <tfoot class="table-warning">
              <tr>
                <th colspan="3" class="text-end">TOTAL GENERAL ($)</th>
                <th><input type="text" id="total_general" class="form-control fw-bold text-center" readonly value="$0.00"></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </form>
    </div>
  </div>

  <!-- ================= TABLA DE MATERIA PRIMA ================= -->
  <div class="card shadow-sm mt-3">
    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
      <h6 class="mb-0">
        Materia Prima - <span id="nombreProductoTabla" class="fw-bold text-uppercase">Sin producto</span>
      </h6>
      <button type="button" class="btn btn-sm btn-success" onclick="agregarFila()">
        <i class="bi bi-plus-circle"></i> Agregar fila
      </button>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0" id="tablaMateriaPrima">
          <thead class="table-primary text-center">
            <tr>
              <th>Materia Prima</th>
              <th width="25%">Costo ($)</th>
              <th width="10%">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="text" class="form-control" name="materia_prima[]"></td>
              <td><input type="number" class="form-control costo" name="costo[]" step="0.01" oninput="calcularTotal()"></td>
              <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger" onclick="eliminarFila(this)">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
          <tfoot class="table-info">
            <tr>
              <th class="text-end">TOTAL</th>
              <th id="totalCosto" class="text-center">0.00</th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

  <!-- DEMÁS CAMPOS -->
  <div class="row mt-4 g-3">
    <div class="col-md-3">
      <label class="form-label fw-semibold">Política de crecimiento (%)</label>
      <input type="number" class="form-control" name="politica_crecimiento" step="0.01" placeholder="0.00">
    </div>

    <div class="col-md-3">
      <label class="form-label fw-semibold">Política de precios (%)</label>
      <input type="number" class="form-control" name="politica_precios" step="0.01" placeholder="0.00">
    </div>

    <div class="col-md-3">
      <label class="form-label fw-semibold">Aumento de costos anualmente (%)</label>
      <input type="number" class="form-control" name="aumento_costos" step="0.01" placeholder="0.00">
    </div>

    <div class="col-md-3">
      <label class="form-label fw-semibold">Mano de obra directa ($)</label>
      <input type="number" class="form-control" name="mod" step="0.01" placeholder="$0.00">
    </div>

    <div class="col-md-3">
      <label class="form-label fw-semibold">Mano de obra al destajo ($)</label>
      <input type="number" class="form-control" name="mod_destajo" step="0.01" placeholder="$0.00">
    </div>

    <div class="col-md-3">
      <label class="form-label fw-semibold">Aumento anual MOD y destajo (%)</label>
      <input type="number" class="form-control" name="aumento_mod_destajo" step="0.01" placeholder="0.00">
    </div>

    <div class="col-md-3">
      <label class="form-label fw-semibold">Pago comisión (%)</label>
      <input type="number" class="form-control" name="pago_comision" step="0.01" placeholder="0.00">
    </div>

    <div class="col-md-3">
      <label class="form-label fw-semibold">Servicios públicos ($)</label>
      <input type="number" class="form-control" name="servicios_publicos" step="0.01" placeholder="$0.00">
    </div>

    <div class="col-12 mt-4">
      <h6 class="fw-bold text-primary border-bottom pb-1">Inversión inicial</h6>
    </div>

    <div class="col-md-3">
      <label class="form-label fw-semibold">Maquinaria y equipo ($)</label>
      <input type="number" class="form-control" name="inversion_maquinaria" step="0.01" placeholder="$0.00">
    </div>

    <div class="col-md-3">
      <label class="form-label fw-semibold">Muebles y enseres ($)</label>
      <input type="number" class="form-control" name="inversion_muebles" step="0.01" placeholder="$0.00">
    </div>

    <div class="col-md-3">
      <label class="form-label fw-semibold">Vehículos ($)</label>
      <input type="number" class="form-control" name="inversion_vehiculos" step="0.01" placeholder="$0.00">
    </div>

    <div class="col-md-3">
      <label class="form-label fw-semibold">Equipo de tecnología ($)</label>
      <input type="number" class="form-control" name="inversion_tecnologia" step="0.01" placeholder="$0.00">
    </div>

    <div class="col-md-3">
      <label class="form-label fw-semibold">Aumento anual de gastos (%)</label>
      <input type="number" class="form-control" name="aumento_gastos" step="0.01" placeholder="0.00">
    </div>

    <div class="col-md-3">
      <label class="form-label fw-semibold">Tasa de oportunidad de evaluación del proyecto (%)</label>
      <input type="text" class="form-control bg-light" id="tasaOportunidad" name="tasa_oportunidad" readonly>
    </div>
  </div>
</div>

<script>
document.getElementById('cantidad_productos').addEventListener('input', function() {
  const cantidad = parseInt(this.value) || 0;
  const tbody = document.getElementById('productos_table_body');
  tbody.innerHTML = '';

  for (let i = 1; i <= cantidad; i++) {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td><input type="text" class="form-control nombre_producto" name="nombre_producto[]" placeholder="Producto ${i}"></td>
      <td><input type="number" class="form-control cantidad" name="cantidad_vender[]" min="0" placeholder="0"></td>
      <td><input type="number" class="form-control precio" name="precio[]" step="0.01" placeholder="$0.00"></td>
      <td><input type="text" class="form-control total" name="total[]" readonly value="$0.00"></td>
    `;
    tbody.appendChild(row);
  }

  actualizarEventos();
});

function actualizarEventos() {
  const cantidades = document.querySelectorAll('.cantidad');
  const precios = document.querySelectorAll('.precio');
  const totales = document.querySelectorAll('.total');
  const nombres = document.querySelectorAll('.nombre_producto');

  function calcularTotales() {
    let totalGeneral = 0;
    cantidades.forEach((cantidadInput, index) => {
      const cantidad = parseFloat(cantidadInput.value) || 0;
      const precio = parseFloat(precios[index].value) || 0;
      const total = cantidad * precio;
      totales[index].value = `$${total.toFixed(2)}`;
      totalGeneral += total;
    });
    document.getElementById('total_general').value = `$${totalGeneral.toFixed(2)}`;
  }

  cantidades.forEach(input => input.addEventListener('input', calcularTotales));
  precios.forEach(input => input.addEventListener('input', calcularTotales));

  // Mostrar el nombre del producto seleccionado en la tabla de materia prima
  nombres.forEach(input => {
    input.addEventListener('focus', () => {
      document.getElementById('nombreProductoTabla').textContent = input.value || 'Sin producto';
    });
    input.addEventListener('input', () => {
      if (document.activeElement === input) {
        document.getElementById('nombreProductoTabla').textContent = input.value || 'Sin producto';
      }
    });
  });
}

// === Funciones tabla materia prima ===
function agregarFila() {
  const tbody = document.querySelector('#tablaMateriaPrima tbody');
  const row = document.createElement('tr');
  row.innerHTML = `
    <td><input type="text" class="form-control" name="materia_prima[]"></td>
    <td><input type="number" class="form-control costo" name="costo[]" step="0.01" oninput="calcularTotal()"></td>
    <td class="text-center">
      <button type="button" class="btn btn-sm btn-danger" onclick="eliminarFila(this)">
        <i class="bi bi-trash"></i>
      </button>
    </td>
  `;
  tbody.appendChild(row);
}

function eliminarFila(btn) {
  btn.closest('tr').remove();
  calcularTotal();
}

function calcularTotal() {
  let total = 0;
  document.querySelectorAll('.costo').forEach(input => {
    total += parseFloat(input.value) || 0;
  });
  document.getElementById('totalCosto').textContent = total.toFixed(2);
}

document.addEventListener('DOMContentLoaded', async () => {
  try {
    const res = await fetch('/api/tasas/ultima');
    if (!res.ok) throw new Error('Error al obtener tasa');
    const data = await res.json();
    document.getElementById('tasaOportunidad').value = data.valor ?? '0.00';
  } catch (err) {
    console.error('No se pudo cargar la tasa de oportunidad', err);
    document.getElementById('tasaOportunidad').value = 'Error';
  }
});

actualizarEventos();
</script>

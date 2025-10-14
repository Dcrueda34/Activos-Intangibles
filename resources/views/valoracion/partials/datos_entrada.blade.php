<div class="card shadow-sm mb-4">
  <div class="card-header bg-primary text-white">
    <h6 class="mb-0">Datos de Entrada</h6>
  </div>

  <div class="card-body">
    <!-- Selección de cantidad de productos -->
    <div class="mb-3">
      <label for="cantidad_productos" class="form-label fw-semibold">Cantidad de productos</label>
      <input type="number" id="cantidad_productos" class="form-control" min="1" max="20" value="1">
    </div>

    <!-- Contenedor dinámico de productos -->
    <div id="productos_container"></div>

    <!-- Campos adicionales -->

  <!-- 🟨 PRIMERA FILA: POLÍTICAS -->
<div class="row">
  <!-- POLÍTICA DE CRECIMIENTO -->
  <div class="col-md-6">
    <!-- Franja amarilla -->
    <div class="text-center fw-bold p-2 mb-0"
         style="background-color: #FFD700; border: 1px solid #000;">
      POLÍTICA DE CRECIMIENTO
    </div>
    <table class="table table-bordered text-center align-middle" style="font-size: 0.85rem;">
      <tbody>
        <tr style="background-color: #dbe4ff;"><td>Crecimiento esperado año 2</td><td><input type="number" name="crecimiento_2" class="form-control text-end" placeholder="%" min="0" max="100" step="0.01"></td></tr>
        <tr style="background-color: #dbe4ff;"><td>Crecimiento esperado año 3</td><td><input type="number" name="crecimiento_3" class="form-control text-end" placeholder="%" min="0" max="100" step="0.01"></td></tr>
        <tr style="background-color: #dbe4ff;"><td>Crecimiento esperado año 4</td><td><input type="number" name="crecimiento_4" class="form-control text-end" placeholder="%" min="0" max="100" step="0.01"></td></tr>
        <tr style="background-color: #dbe4ff;"><td>Crecimiento esperado año 5</td><td><input type="number" name="crecimiento_5" class="form-control text-end" placeholder="%" min="0" max="100" step="0.01"></td></tr>
      </tbody>
    </table>
  </div>

  <!-- POLÍTICA DE PRECIOS -->
  <div class="col-md-6">
    <!-- Franja amarilla -->
    <div class="text-center fw-bold p-2 mb-0"
         style="background-color: #FFD700; border: 1px solid #000;">
      POLÍTICA DE PRECIOS
    </div>
    <table class="table table-bordered text-center align-middle" style="font-size: 0.85rem;">
      <tbody>
        <tr style="background-color: #dbe4ff;"><td>Año 2</td><td><input type="number" name="precio_2" class="form-control text-end" placeholder="%" min="0" max="100" step="0.01"></td></tr>
        <tr style="background-color: #dbe4ff;"><td>Año 3</td><td><input type="number" name="precio_3" class="form-control text-end" placeholder="%" min="0" max="100" step="0.01"></td></tr>
        <tr style="background-color: #dbe4ff;"><td>Año 4</td><td><input type="number" name="precio_4" class="form-control text-end" placeholder="%" min="0" max="100" step="0.01"></td></tr>
        <tr style="background-color: #dbe4ff;"><td>Año 5</td><td><input type="number" name="precio_5" class="form-control text-end" placeholder="%" min="0" max="100" step="0.01"></td></tr>
      </tbody>
    </table>
  </div>
</div>

<!-- 🟩 SEGUNDA FILA: COSTOS Y MANO DE OBRA -->
<div class="row">
  <!-- AUMENTO DE COSTOS ANUALES -->
  <div class="col-md-6">
    <!-- Franja amarilla -->
    <div class="text-center fw-bold p-2 mb-0"
         style="background-color: #FFD700; border: 1px solid #000;">
      AUMENTO DE COSTOS ANUALES
    </div>
    <table class="table table-bordered text-center align-middle" style="font-size: 0.85rem;">
      <tbody>
        <tr style="background-color: #dbe4ff;"><td>Año 2</td><td><input type="number" name="costo_anual_2" class="form-control text-end" placeholder="%" min="0" max="100" step="0.01"></td></tr>
        <tr style="background-color: #dbe4ff;"><td>Año 3</td><td><input type="number" name="costo_anual_3" class="form-control text-end" placeholder="%" min="0" max="100" step="0.01"></td></tr>
        <tr style="background-color: #dbe4ff;"><td>Año 4</td><td><input type="number" name="costo_anual_4" class="form-control text-end" placeholder="%" min="0" max="100" step="0.01"></td></tr>
        <tr style="background-color: #dbe4ff;"><td>Año 5</td><td><input type="number" name="costo_anual_5" class="form-control text-end" placeholder="%" min="0" max="100" step="0.01"></td></tr>
      </tbody>
    </table>
  </div>

  <!-- MANO DE OBRA DIRECTA -->
  <div class="col-md-6">
    <!-- Franja amarilla -->
    <div class="text-center fw-bold p-2 mb-0"
         style="background-color: #FFD700; border: 1px solid #000;">
      MANO DE OBRA DIRECTA
    </div>
    <table class="table table-bordered text-center align-middle" style="font-size: 0.85rem;">
      <thead>
        <tr style="background-color: #dbe4ff;">
          <th>MANO DE OBRA DIRECTA</th>
          <th>SALARIO</th>
          <th>ACCIONES</th>
        </tr>
      </thead>
      <tbody id="manoObraTable">
        <tr>
          <td><input type="text" name="mano_obra[]" class="form-control" placeholder="Ej: Cocinero"></td>
          <td><input type="number" name="salario[]" class="form-control text-end salario" placeholder="$0.00" step="0.01" min="0"></td>
          <td><button type="button" class="btn btn-sm btn-danger eliminar-fila"><i class="bi bi-trash"></i></button></td>
        </tr>
      </tbody>
      <tfoot style="background-color: #dbe4ff;">
        <tr>
          <th>TOTAL</th>
          <th id="totalSalarios">0</th>
          <th>
            <button type="button" class="btn btn-sm btn-success" id="agregarFila">
              <i class="bi bi-plus-circle"></i>
            </button>
          </th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>


      <div class="col-md-3">
        <label class="form-label fw-semibold">Tasa de oportunidad de evaluación del proyecto (%)</label>
        <input type="text" class="form-control bg-light" id="tasaOportunidad" name="tasa_oportunidad" readonly>
      </div>
    </div>
  </div>
</div>

<script>

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

const container = document.getElementById('productos_container');
const inputCantidad = document.getElementById('cantidad_productos');

// Generar productos dinámicamente
inputCantidad.addEventListener('input', () => {
  const cantidad = parseInt(inputCantidad.value) || 0;
  container.innerHTML = '';

  for (let i = 1; i <= cantidad; i++) {
    const card = document.createElement('div');
    card.classList.add('card', 'shadow-sm', 'mb-4', 'producto-card');

    card.innerHTML = `
      <div class="card-header bg-warning text-dark fw-bold">
        Producto ${i}
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label fw-semibold">Nombre del producto</label>
            <input type="text" class="form-control nombre-producto" name="nombre_producto[]" placeholder="Ej: Producto ${i}">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Cantidad a vender</label>
            <input type="number" class="form-control cantidad" name="cantidad_vender[]" min="0" placeholder="0">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Precio unitario ($)</label>
            <input type="number" class="form-control precio" name="precio[]" step="0.01" placeholder="$0.00">
          </div>
        </div>

        <div class="col-md-2 mb-3">
          <label class="form-label fw-semibold">Total producto ($)</label>
          <input type="text" class="form-control producto-total" name="producto_total[]" readonly value="$0.00">
        </div>

        <div class="table-responsive mt-4">
          <table class="table table-bordered align-middle mb-0 tabla-materias">
            <thead class="table-primary text-center">
              <tr>
                <th class="th-mp">Materia Prima</th>
                <th width="25%">Costo ($)</th>
                <th width="10%">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="text" class="form-control" name="materia_prima[${i}][]"></td>
                <td><input type="number" class="form-control costo" name="costo[${i}][]" step="0.01"></td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-danger eliminar-fila">
                    <i class="bi bi-trash"></i>
                  </button>
                </td>
              </tr>
            </tbody>
            <tfoot class="table-info">
              <tr>
                <th class="text-end">TOTAL MATERIAS</th>
                <th class="total-costo text-center">0.00</th>
                <th>
                  <button type="button" class="btn btn-sm btn-success agregar-fila">
                    <i class="bi bi-plus-circle"></i>
                  </button>
                </th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    `;
    container.appendChild(card);
  }

  inicializarEventos();
});

function inicializarEventos() {
  // 🔹 Actualizar encabezado de "Materia Prima" dentro de la tabla
  document.querySelectorAll('.nombre-producto').forEach(input => {
    input.addEventListener('input', e => {
      const card = e.target.closest('.producto-card');
      const thMateriaPrima = card.querySelector('.th-mp');
      const nombre = e.target.value.trim();
      thMateriaPrima.textContent = nombre
        ? `Materia Prima de ${nombre}`
        : 'Materia Prima';
    });
  });

  // 🔹 Agregar filas dinámicamente
  document.querySelectorAll('.agregar-fila').forEach(btn => {
    btn.addEventListener('click', e => {
      const tabla = e.target.closest('table');
      const tbody = tabla.querySelector('tbody');
      const index = Array.from(document.querySelectorAll('.tabla-materias')).indexOf(tabla);
      const fila = document.createElement('tr');
      fila.innerHTML = `
        <td><input type="text" class="form-control" name="materia_prima[${index+1}][]"></td>
        <td><input type="number" class="form-control costo" name="costo[${index+1}][]" step="0.01"></td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-danger eliminar-fila">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      `;
      tbody.appendChild(fila);
      inicializarEventos();
    });
  });

  // 🔹 Eliminar filas
  document.querySelectorAll('.eliminar-fila').forEach(btn => {
    btn.addEventListener('click', e => {
      e.target.closest('tr').remove();
      actualizarTotales();
    });
  });

  // 🔹 Cálculo de totales
  document.querySelectorAll('.costo, .cantidad, .precio').forEach(input => {
    input.addEventListener('input', actualizarTotales);
  });
}

function calcularTotalMP(tabla) {
  let total = 0;
  tabla.querySelectorAll('.costo').forEach(input => {
    total += parseFloat(input.value) || 0;
  });
  tabla.querySelector('.total-costo').textContent = total.toFixed(2);
  return total;
}

function calcularTotalProducto(card) {
  const cantidad = parseFloat(card.querySelector('.cantidad')?.value) || 0;
  const precio = parseFloat(card.querySelector('.precio')?.value) || 0;
  const tabla = card.querySelector('.tabla-materias');
  const totalMP = tabla ? calcularTotalMP(tabla) : 0;
  const totalProducto = (cantidad * precio) + totalMP;
  const inputTotal = card.querySelector('.producto-total');
  if (inputTotal) inputTotal.value = `$${totalProducto.toFixed(2)}`;
  return totalProducto;
}

function actualizarTotales() {
  document.querySelectorAll('.producto-card').forEach(card => {
    calcularTotalProducto(card);
  });
}

// 🔹 Función para recalcular total salarios
  function calcularTotalSalarios() {
    let total = 0;
    document.querySelectorAll('.salario').forEach(input => {
      total += parseFloat(input.value) || 0;
    });
    document.getElementById("totalSalarios").textContent = total.toLocaleString("es-CO", {
      style: "currency",
      currency: "COP"
    });
  }

  // 🔹 Agregar fila dinámica
  document.getElementById("agregarFila").addEventListener("click", () => {
    const tbody = document.getElementById("manoObraTable");
    const fila = document.createElement("tr");
    fila.innerHTML = `
      <td><input type="text" name="mano_obra[]" class="form-control" placeholder="Ej: Mesero"></td>
      <td><input type="number" name="salario[]" class="form-control text-end salario" placeholder="$0.00" step="0.01" min="0"></td>
      <td><button type="button" class="btn btn-sm btn-danger eliminar-fila"><i class="bi bi-trash"></i></button></td>
    `;
    tbody.appendChild(fila);
  });

  // 🔹 Eliminar fila dinámica
  document.addEventListener("click", e => {
    if (e.target.closest(".eliminar-fila")) {
      e.target.closest("tr").remove();
      calcularTotalSalarios();
    }
  });

  // 🔹 Actualizar total cuando cambian los salarios
  document.addEventListener("input", e => {
    if (e.target.classList.contains("salario")) {
      calcularTotalSalarios();
    }
  });
// Inicial
inputCantidad.dispatchEvent(new Event('input'));
</script>




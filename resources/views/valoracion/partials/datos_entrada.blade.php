<div class="card shadow-sm mb-4">
  <div class="card-header bg-primary text-white">
    <h6 class="mb-0">Datos de Entrada</h6>
  </div>

  <div class="card-body">
    <!-- Cantidad de productos -->
    <div class="mb-3">
      <label for="cantidad_productos" class="form-label fw-semibold">Cantidad de productos</label>
      <input type="number" id="cantidad_productos" class="form-control" min="1" max="20" value="1">
    </div>

    <!-- Contenedor de productos dinámicos -->
    <div id="productos_container"></div>

    <!-- 🟨 POLÍTICAS DE CRECIMIENTO Y PRECIOS -->
    <div class="row">
      <div class="col-md-6">
        <div class="text-center fw-bold p-2 mb-0" style="background-color: #FFD700; border: 1px solid #000;">
          POLÍTICA DE CRECIMIENTO
        </div>
        <table class="table table-bordered text-center align-middle" style="font-size: 0.85rem;">
          <tbody>
            @for($i=2;$i<=5;$i++)
            <tr style="background-color: #dbe4ff;">
              <td>Crecimiento esperado año {{ $i }}</td>
              <td><input type="number" name="crecimiento_{{ $i }}" class="form-control text-end" placeholder="%" min="0" max="100" step="0.01"></td>
            </tr>
            @endfor
          </tbody>
        </table>
      </div>

      <div class="col-md-6">
        <div class="text-center fw-bold p-2 mb-0" style="background-color: #FFD700; border: 1px solid #000;">
          POLÍTICA DE PRECIOS
        </div>
        <table class="table table-bordered text-center align-middle" style="font-size: 0.85rem;">
          <tbody>
            @for($i=2;$i<=5;$i++)
            <tr style="background-color: #dbe4ff;">
              <td>Año {{ $i }}</td>
              <td><input type="number" name="precio_{{ $i }}" class="form-control text-end" placeholder="%" min="0" max="100" step="0.01"></td>
            </tr>
            @endfor
          </tbody>
        </table>
      </div>
    </div>

    <!-- 🟩 COSTOS Y MANO DE OBRA DIRECTA -->
    <div class="row">
      <div class="col-md-6">
        <div class="text-center fw-bold p-2 mb-0" style="background-color: #FFD700; border: 1px solid #000;">
          AUMENTO DE COSTOS ANUALES
        </div>
        <table class="table table-bordered text-center align-middle" style="font-size: 0.85rem;">
          <tbody>
            @for($i=2;$i<=5;$i++)
            <tr style="background-color: #dbe4ff;">
              <td>Año {{ $i }}</td>
              <td><input type="number" name="costo_anual_{{ $i }}" class="form-control text-end" placeholder="%" min="0" max="100" step="0.01"></td>
            </tr>
            @endfor
          </tbody>
        </table>
      </div>

      <div class="col-md-6">
        <div class="text-center fw-bold p-2 mb-0" style="background-color: #FFD700; border: 1px solid #000;">
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

    <!-- 🟦 MANO DE OBRA AL DESTAJO Y TASA DE OPORTUNIDAD -->
    <div class="row">
      <div class="col-md-8">
        <div class="text-center fw-bold p-2 mb-0" style="background-color: #FFD700; border: 1px solid #000;">
          MANO DE OBRA AL DESTAJO
        </div>
        <table class="table table-bordered text-center align-middle" style="font-size: 0.85rem;">
          <thead>
            <tr style="background-color: #dbe4ff;">
              <th>DESCRIPCIÓN</th>
              <th>SALARIO (COP)</th>
              <th>ACCIONES</th>
            </tr>
          </thead>
          <tbody id="manoObraDestajoTable">
            <tr>
              <td><input type="text" name="mano_obra_destajo[]" class="form-control" placeholder="Ej: Diseñador freelance"></td>
              <td><input type="number" name="salario_destajo[]" class="form-control text-end salario-destajo" placeholder="$0.00" step="0.01" min="0"></td>
              <td><button type="button" class="btn btn-sm btn-danger eliminar-fila-destajo"><i class="bi bi-trash"></i></button></td>
            </tr>
          </tbody>
          <tfoot style="background-color: #dbe4ff;">
            <tr>
              <th>TOTAL</th>
              <th id="totalSalariosDestajo">0</th>
              <th>
                <button type="button" class="btn btn-sm btn-success" id="agregarFilaDestajo">
                  <i class="bi bi-plus-circle"></i>
                </button>
              </th>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="col-md-4">
        <div class="text-center fw-bold p-2 mb-0" style="background-color: #FFD700; border: 1px solid #000;">
          TASA DE OPORTUNIDAD
        </div>
        <div class="p-3 border border-primary bg-light">
          <label for="tasaOportunidad" class="form-label fw-semibold text-center d-block">
            Tasa de oportunidad de evaluación del proyecto (%)
          </label>
          <input type="text" class="form-control text-center fw-bold" id="tasaOportunidad" name="tasa_oportunidad" readonly>
        </div>
      </div>
    </div>

    <!-- 🟪 INSUMOS Y MATERIALES INDIRECTOS -->
    <div class="card shadow-sm mb-4 mt-4">
      <div class="card-header bg-primary text-white">
        <h6 class="mb-0">Insumos y Materiales Indirectos</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered align-middle text-center" id="tablaInsumos">
            <thead class="table-warning">
              <tr>
                <th>Descripción</th>
                <th>Unidad de Medida</th>
                <th>Cantidad</th>
                <th>Costo Unitario (COP)</th>
                <th>Total (COP)</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="text" class="form-control" placeholder="Ej: Licencias, papelería, energía..." /></td>
                <td><input type="text" class="form-control" placeholder="Unidad" /></td>
                <td><input type="number" class="form-control cantidadInsumo" min="0" value="0" /></td>
                <td><input type="number" class="form-control costoInsumo" min="0" value="0" /></td>
                <td><input type="number" class="form-control totalInsumo" readonly /></td>
                <td>
                  <button type="button" class="btn btn-sm btn-success agregarInsumo">+</button>
                  <button type="button" class="btn btn-sm btn-danger eliminarInsumo">-</button>
                </td>
              </tr>
            </tbody>
            <tfoot class="table-primary">
              <tr>
                <th colspan="4" class="text-end">TOTAL INSUMOS Y MATERIALES INDIRECTOS:</th>
                <th><input type="number" class="form-control" id="totalGeneralInsumos" readonly /></th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async () => {
  // Cargar tasa de oportunidad
  try {
    const res = await fetch('/api/tasas/ultima');
    const data = await res.json();
    document.getElementById('tasaOportunidad').value = data.valor ?? '0.00';
  } catch (err) {
    console.error(err);
    document.getElementById('tasaOportunidad').value = 'Error';
  }

  const container = document.getElementById('productos_container');
  const inputCantidad = document.getElementById('cantidad_productos');

  // Generar productos dinámicos
  inputCantidad.addEventListener('input', () => {
    const cantidad = parseInt(inputCantidad.value) || 0;
    container.innerHTML = '';
    for (let i=1;i<=cantidad;i++){
      const card = document.createElement('div');
      card.classList.add('card','shadow-sm','mb-4','producto-card');
      card.innerHTML = `
        <div class="card-header bg-warning text-dark fw-bold">Producto ${i}</div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label fw-semibold">Nombre del producto</label>
              <input type="text" class="form-control nombre-producto" name="nombre_producto[]" placeholder="Producto ${i}">
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
            <table class="table table-bordered align-middle mb-0 tabla-materias" style="font-size:0.9rem;">
              <thead class="table-primary text-center">
                <tr>
                  <th class="th-mp">Materia Prima</th>
                  <th width="25%">Costo ($)</th>
                  <th width="15%">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><input type="text" class="form-control" name="materia_prima[${i}][]" placeholder="Ej: Hilo, tela, pintura..."></td>
                  <td><input type="number" class="form-control costo" name="costo[${i}][]" step="0.01" min="0"></td>
                  <td class="text-center">
                    <div class="d-flex justify-content-center align-items-center gap-2">
                      <button type="button" class="btn btn-sm btn-success agregar-fila"><i class="bi bi-plus-circle"></i></button>
                      <button type="button" class="btn btn-sm btn-danger eliminar-fila"><i class="bi bi-trash"></i></button>
                    </div>
                  </td>
                </tr>
              </tbody>
              <tfoot class="table-info">
                <tr>
                  <th colspan="1" class="text-end">TOTAL MATERIA PRIMA</th>
                  <th class="total-costo text-center">0.00</th>
                  <th></th>
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

  inputCantidad.dispatchEvent(new Event('input')); // Inicial

  // ===== Funciones =====
  function inicializarEventos() {
    // Actualizar nombre materia prima
    document.querySelectorAll('.nombre-producto').forEach(input => {
      input.addEventListener('input', e=>{
        const card = e.target.closest('.producto-card');
        const th = card.querySelector('.th-mp');
        th.textContent = e.target.value ? `Materia Prima de ${e.target.value}` : 'Materia Prima';
      });
    });

    // Agregar fila materia prima
    document.querySelectorAll('.agregar-fila').forEach(btn=>{
      btn.onclick = e=>{
        const tabla = e.target.closest('table');
        const tbody = tabla.querySelector('tbody');
        const index = Array.from(document.querySelectorAll('.tabla-materias')).indexOf(tabla);
        const fila = document.createElement('tr');
        fila.innerHTML = `
          <td><input type="text" class="form-control" name="materia_prima[${index+1}][]" placeholder="Ej: Hilo, tela, pintura..."></td>
          <td><input type="number" class="form-control costo" name="costo[${index+1}][]" step="0.01" min="0"></td>
          <td class="text-center">
            <div class="d-flex justify-content-center align-items-center gap-2">
              <button type="button" class="btn btn-sm btn-success agregar-fila"><i class="bi bi-plus-circle"></i></button>
              <button type="button" class="btn btn-sm btn-danger eliminar-fila"><i class="bi bi-trash"></i></button>
            </div>
          </td>
        `;
        tbody.appendChild(fila);
        inicializarEventos();
      };
    });

    // Eliminar fila materia prima
    document.querySelectorAll('.eliminar-fila').forEach(btn=>{
      btn.onclick = e=>{
        const tabla = e.target.closest('table');
        const filas = tabla.querySelectorAll('tbody tr');
        if(filas.length>1) e.target.closest('tr').remove();
        actualizarTotalesProductos();
      };
    });

    // Calcular totales productos
    document.querySelectorAll('.costo, .cantidad, .precio').forEach(input=>{
      input.oninput = actualizarTotalesProductos;
    });
  }

  function calcularTotalMP(tabla){
    let total=0;
    tabla.querySelectorAll('.costo').forEach(i=>{total += parseFloat(i.value)||0});
    tabla.querySelector('.total-costo').textContent = total.toFixed(2);
    return total;
  }

  function calcularTotalProducto(card){
    const cantidad = parseFloat(card.querySelector('.cantidad')?.value) || 0;
    const precio = parseFloat(card.querySelector('.precio')?.value) || 0;
    const tabla = card.querySelector('.tabla-materias');
    const totalMP = tabla ? calcularTotalMP(tabla) : 0;
    const totalProducto = (cantidad*precio)+totalMP;
    const inputTotal = card.querySelector('.producto-total');
    if(inputTotal) inputTotal.value = `$${totalProducto.toFixed(2)}`;
    return totalProducto;
  }

  function actualizarTotalesProductos(){
    document.querySelectorAll('.producto-card').forEach(card=>calcularTotalProducto(card));
  }

  // ===== Mano de obra directa =====
  function calcularTotalSalarios(){
    let total=0;
    document.querySelectorAll('.salario').forEach(i=>{total+=parseFloat(i.value)||0});
    document.getElementById("totalSalarios").textContent = total.toLocaleString("es-CO",{style:"currency",currency:"COP"});
  }

  document.getElementById("agregarFila").addEventListener("click", ()=>{
    const tbody=document.getElementById("manoObraTable");
    const fila=document.createElement("tr");
    fila.innerHTML=`
      <td><input type="text" name="mano_obra[]" class="form-control" placeholder="Ej: Mesero"></td>
      <td><input type="number" name="salario[]" class="form-control text-end salario" placeholder="$0.00" step="0.01" min="0"></td>
      <td><button type="button" class="btn btn-sm btn-danger eliminar-fila"><i class="bi bi-trash"></i></button></td>
    `;
    tbody.appendChild(fila);
  });

  document.addEventListener("input", (e)=>{ if(e.target.classList.contains("salario")) calcularTotalSalarios(); });
  document.addEventListener("click", (e)=>{ if(e.target.closest(".eliminar-fila")){e.target.closest("tr").remove(); calcularTotalSalarios();} });

  // ===== Mano de obra al destajo =====
  function calcularTotalSalariosDestajo(){
    let total=0;
    document.querySelectorAll('.salario-destajo').forEach(i=>{total+=parseFloat(i.value)||0});
    document.getElementById("totalSalariosDestajo").textContent = total.toLocaleString("es-CO",{style:"currency",currency:"COP"});
  }

  document.getElementById("agregarFilaDestajo").addEventListener("click", ()=>{
    const tbody=document.getElementById("manoObraDestajoTable");
    const fila=document.createElement("tr");
    fila.innerHTML=`
      <td><input type="text" name="mano_obra_destajo[]" class="form-control" placeholder="Ej: Diseñador freelance"></td>
      <td><input type="number" name="salario_destajo[]" class="form-control text-end salario-destajo" placeholder="$0.00" step="0.01" min="0"></td>
      <td><button type="button" class="btn btn-sm btn-danger eliminar-fila-destajo"><i class="bi bi-trash"></i></button></td>
    `;
    tbody.appendChild(fila);
  });

  document.addEventListener("input", (e)=>{ if(e.target.classList.contains("salario-destajo")) calcularTotalSalariosDestajo(); });
  document.addEventListener("click", (e)=>{ if(e.target.closest(".eliminar-fila-destajo")){e.target.closest("tr").remove(); calcularTotalSalariosDestajo();} });

  // ===== Insumos =====
  function actualizarTotalInsumos(fila){
    const cantidad = parseFloat(fila.querySelector('.cantidadInsumo').value)||0;
    const costo = parseFloat(fila.querySelector('.costoInsumo').value)||0;
    fila.querySelector('.totalInsumo').value = (cantidad*costo).toFixed(2);
  }

  function actualizarTotalGeneralInsumos(){
    let total=0;
    document.querySelectorAll('.totalInsumo').forEach(i=>total+=parseFloat(i.value)||0);
    document.getElementById('totalGeneralInsumos').value = total.toFixed(2);
  }

  document.addEventListener('input', e=>{
    if(e.target.classList.contains('cantidadInsumo') || e.target.classList.contains('costoInsumo')){
      const fila = e.target.closest('tr');
      actualizarTotalInsumos(fila);
      actualizarTotalGeneralInsumos();
    }
  });

  document.addEventListener('click', e=>{
    if(e.target.classList.contains('agregarInsumo')){
      const fila = e.target.closest('tr');
      const nuevaFila = fila.cloneNode(true);
      nuevaFila.querySelectorAll('input').forEach(i=>i.value=0);
      fila.closest('tbody').appendChild(nuevaFila);
    }
    if(e.target.classList.contains('eliminarInsumo')){
      const tbody = e.target.closest('tbody');
      if(tbody.querySelectorAll('tr').length>1) e.target.closest('tr').remove();
      actualizarTotalGeneralInsumos();
    }
  });

});
</script>

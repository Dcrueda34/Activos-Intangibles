<div class="card shadow-sm mb-4">
  <div class="card-header bg-secondary text-white">
    <h6 class="mb-0">Valoración de Activos Intangibles</h6>
  </div>
  <div class="card-body">

    <div class="row mb-4">
      <div class="col-md-4">
        <label class="form-label fw-semibold">Valor proyectado de la empresa (COP)</label>
        <input type="number" class="form-control" value="{{ $valorProyectado }}" readonly>
      </div>
      <div class="col-md-4">
        <label class="form-label fw-semibold">Activos tangibles a precios de mercado (COP)</label>
        <input type="number" class="form-control" value="{{ $activosTangibles }}" readonly>
      </div>
      <div class="col-md-4">
        <label class="form-label fw-semibold">Valor de los activos intangibles (COP)</label>
        <input type="number" class="form-control" value="{{ $valorIntangibles }}" readonly>
      </div>
    </div>

    <h6 class="fw-bold mb-3">Segregación de Intangibles</h6>
    <div class="table-responsive">
      <table class="table table-bordered text-center" style="font-size: 0.85rem;">
        <thead class="table-warning">
          <tr>
            <th>Tipo de Intangible</th>
            <th>Valor (COP)</th>
          </tr>
        </thead>
        <tbody id="tablaIntangibles">
          @php
            $tipos = ['Secretos empresariales y Know How','Prima comercial','Patentes','Marcas','Nombres comerciales','Derechos de autor','Otros derechos'];
          @endphp
          @foreach ($tipos as $tipo)
          <tr>
            <td>{{ $tipo }}</td>
            <td><input type="number" class="form-control intangible" step="0.01" min="0" value="0"></td>
          </tr>
          @endforeach
        </tbody>
        <tfoot class="table-primary">
          <tr>
            <th>Total Intangibles</th>
            <th id="totalIntangibles">0.00</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const intangiblesInputs = document.querySelectorAll('.intangible');
  const totalIntangibles = document.getElementById('totalIntangibles');

  function actualizarTotales() {
    let total = 0;
    intangiblesInputs.forEach(input => {
      total += parseFloat(input.value) || 0;
    });
    totalIntangibles.textContent = total.toFixed(2);
  }

  intangiblesInputs.forEach(input => input.addEventListener('input', actualizarTotales));
  actualizarTotales();
});
</script>

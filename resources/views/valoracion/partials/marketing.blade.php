<div class="card shadow-sm p-4">
  <h5 class="mb-4 text-primary">
    Proyección de Inversión en Marketing y Publicidad
  </h5>

  <div class="table-responsive">
    <table class="table table-bordered align-middle text-center" style="background-color:#eef2ff;">
      <thead class="table-light">
        <tr>
          <th class="text-start">Tipo Acción</th>
          <th class="text-success fw-bold">AÑO 1</th>
          <th>Aumento año 2</th>
          <th>Aumento año 3</th>
          <th>Aumento año 4</th>
          <th>Aumento año 5</th>
        </tr>
      </thead>

      <tbody>
        @php
          $acciones = ['Internet', 'Publicidad', 'Volantes', 'Marketing Directo', 'Publicidad Radio'];
        @endphp

        @foreach($acciones as $accion)
        <tr>
          <td class="text-start">{{ $accion }}</td>
          <td><input type="number" class="form-control form-control-sm marketing-input" step="0.01" name="{{ $accion }}_a1"></td>
          <td><input type="number" class="form-control form-control-sm marketing-input" step="0.01" name="{{ $accion }}_a2"></td>
          <td><input type="number" class="form-control form-control-sm marketing-input" step="0.01" name="{{ $accion }}_a3"></td>
          <td><input type="number" class="form-control form-control-sm marketing-input" step="0.01" name="{{ $accion }}_a4"></td>
          <td><input type="number" class="form-control form-control-sm marketing-input" step="0.01" name="{{ $accion }}_a5"></td>
        </tr>
        @endforeach

        <tr class="table-primary fw-bold">
          <td class="text-start">TOTAL</td>
          <td colspan="5" class="text-end pe-3">$ <span id="totalMarketing">0.00</span></td>
        </tr>
      </tbody>
    </table>
  </div>

  <p class="text-muted small mt-2">
    * Los valores pueden ajustarse según las proyecciones anuales. El total se calcula automáticamente.
  </p>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const inputs = document.querySelectorAll('.marketing-input');
  const totalEl = document.getElementById('totalMarketing');

  function calcularTotal() {
    let total = 0;
    inputs.forEach(input => {
      total += parseFloat(input.value) || 0;
    });
    totalEl.textContent = total.toLocaleString('es-CO', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  }

  inputs.forEach(i => i.addEventListener('input', calcularTotal));
});
</script>
@endsection

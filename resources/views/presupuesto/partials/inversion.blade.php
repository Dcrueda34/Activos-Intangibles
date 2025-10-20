<h6 class="fw-bold mb-2">Presupuesto de Inversiones de Capital</h6>
<table class="table table-bordered text-center">
  <thead class="table-light">
    <tr><th>Proyecto</th><th>Inversión (COP)</th></tr>
  </thead>
  <tbody>
    @foreach($inversiones as $inv)
    <tr>
      <td>{{ $inv['nombre'] }}</td>
      <td>{{ number_format($inv['monto'],2) }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

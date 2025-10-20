<h6 class="fw-bold mb-2">Presupuesto de Gastos Administrativos</h6>
<table class="table table-bordered text-center">
  <thead class="table-light">
    <tr><th>Concepto</th><th>Monto</th></tr>
  </thead>
  <tbody>
    @foreach($admin as $gasto)
    <tr>
      <td>{{ $gasto['nombre'] }}</td>
      <td>{{ number_format($gasto['monto'],2) }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

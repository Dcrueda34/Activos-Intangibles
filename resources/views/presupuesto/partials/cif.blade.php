<h6 class="fw-bold mb-2">Presupuesto de Costos Indirectos de Fabricación</h6>
<table class="table table-bordered text-center">
  <thead class="table-light">
    <tr><th>Concepto</th><th>Monto</th></tr>
  </thead>
  <tbody>
    @foreach($cif as $concepto)
    <tr>
      <td>{{ $concepto['nombre'] }}</td>
      <td>{{ number_format($concepto['monto'],2) }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

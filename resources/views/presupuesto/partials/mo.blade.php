<h6 class="fw-bold mb-2">Presupuesto de Mano de Obra</h6>
<table class="table table-bordered text-center">
  <thead class="table-light">
    <tr><th>Empleado</th><th>Horas</th><th>Tarifa Hora</th><th>Total</th></tr>
  </thead>
  <tbody>
    @foreach($mo as $empleado)
    <tr>
      <td>{{ $empleado['nombre'] }}</td>
      <td>{{ $empleado['horas'] }}</td>
      <td>{{ number_format($empleado['tarifa'],2) }}</td>
      <td>{{ number_format($empleado['total'],2) }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

<h6 class="fw-bold mb-2">Presupuesto de Compras</h6>
<table class="table table-bordered text-center">
  <thead class="table-light">
    <tr>
      <th>Material</th><th>Cantidad</th><th>Precio Unitario</th><th>Total</th>
    </tr>
  </thead>
  <tbody>
    @foreach($compras as $item)
    <tr>
      <td>{{ $item['nombre'] }}</td>
      <td>{{ $item['cantidad'] }}</td>
      <td>{{ number_format($item['precio'],2) }}</td>
      <td>{{ number_format($item['total'],2) }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

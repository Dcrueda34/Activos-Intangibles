<h6 class="fw-bold mb-2">Presupuesto de Mercadeo y Publicidad</h6>
<table class="table table-bordered text-center">
    <thead class="table-light">
        <tr>
            <th>Campaña</th>
            <th>Costo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($mercadeo as $camp)
        <tr>
            <td>{{ $camp['nombre'] }}</td>
            <td>{{ number_format($camp['costo'],2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
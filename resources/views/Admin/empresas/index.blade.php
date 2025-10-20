<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Empresas / Proyectos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background:#f8fafc; }
    .card { border-radius: 16px; }
    .table thead th { white-space:nowrap; }
    .cursor-pointer { cursor:pointer; }
  </style>
</head>
<body>
<div class="container py-4">
  <div class="d-flex align-items-center mb-3">
    <h1 class="h3 mb-0">Empresas (Proyectos)</h1>
    <div class="ms-auto">
      <button class="btn btn-primary" id="btnNuevo"><i class="bi bi-plus-circle"></i> Nuevo</button>
    </div>
  </div>

  <!-- Filtros -->
  <div class="card mb-3">
    <div class="card-body">
      <form id="formFiltros" class="row g-2 align-items-end">
        <div class="col-sm-6 col-md-3">
          <label class="form-label">Buscar por nombre</label>
          <input type="text" class="form-control" name="search" placeholder="Ej: Lavado de carros">
        </div>
        <div class="col-sm-6 col-md-2">
          <label class="form-label">Desde</label>
          <input type="date" class="form-control" name="from">
        </div>
        <div class="col-sm-6 col-md-2">
          <label class="form-label">Hasta</label>
          <input type="date" class="form-control" name="to">
        </div>
        <div class="col-sm-6 col-md-2">
          <label class="form-label">Ordenar por</label>
          <select class="form-select" name="order_by">
            <option value="ID_Proyecto">ID</option>
            <option value="nombre">Nombre</option>
            <option value="fecha">Fecha</option>
          </select>
        </div>
        <div class="col-sm-6 col-md-1">
          <label class="form-label">Dirección</label>
          <select class="form-select" name="order_dir">
            <option value="desc">Desc</option>
            <option value="asc">Asc</option>
          </select>
        </div>
        <div class="col-sm-6 col-md-2">
          <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" id="soloNoLiquidados" name="solo_no_liquidados" value="1">
            <label class="form-check-label" for="soloNoLiquidados">Solo no liquidados</label>
          </div>
        </div>
        <div class="col-12 col-md-12 d-flex gap-2 mt-2">
          <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Buscar</button>
          <button class="btn btn-outline-secondary" type="button" id="btnLimpiar"><i class="bi bi-x-circle"></i> Limpiar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Tabla -->
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table align-middle" id="tabla">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Fecha</th>
              <th>Descripción</th>
              <th>Certificado</th>
              <th class="text-end">Acciones</th>
            </tr>
          </thead>
          <tbody id="tbody">
            <!-- Tabla vacía al inicio -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Crear/Editar -->
<div class="modal fade" id="modalProyecto" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <form class="modal-content" id="formProyecto">
      <div class="modal-header">
        <h5 class="modal-title" id="titleProyecto">Nuevo proyecto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="_id" id="_id">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nombre</label>
            <input class="form-control" name="nombre" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Fecha</label>
            <input type="date" class="form-control" name="fecha">
          </div>
          <div class="col-12">
            <label class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" rows="3"></textarea>
          </div>
          <div class="col-12">
            <label class="form-label">Certificado (pdf/zip/jpg/png)</label>
            <input type="file" class="form-control" name="certificado" accept=".pdf,.zip,.jpg,.jpeg,.png">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
        <button class="btn btn-primary" type="submit">Guardar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Vincular Usuarios -->
<div class="modal fade" id="modalVincular" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <form class="modal-content" id="formVincularUsuarios">
      <div class="modal-header">
        <h5 class="modal-title">Vincular Usuarios</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="vincular_ID_Proyecto">
        <div id="usuariosList">
          <!-- Lista de usuarios con checkboxes se carga aquí -->
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
        <button class="btn btn-success" type="submit">Vincular</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const API_BASE = '/api';
const $ = (sel) => document.querySelector(sel);

const toast = (msg, type='primary') => {
  const el = document.createElement('div');
  el.className = `alert alert-${type} position-fixed top-0 end-0 m-3`;
  el.style.zIndex = 1080;
  el.textContent = msg;
  document.body.appendChild(el);
  setTimeout(()=> el.remove(), 2500);
};

// ===== Cargar proyectos según filtros
async function loadProyectos() {
  const formData = new FormData($('#formFiltros'));
  const params = new URLSearchParams();

  if (formData.get('search')) params.append('search', formData.get('search'));
  if (formData.get('from')) params.append('from', formData.get('from'));
  if (formData.get('to')) params.append('to', formData.get('to'));
  if (formData.get('order_by')) params.append('order_by', formData.get('order_by'));
  if (formData.get('order_dir')) params.append('order_dir', formData.get('order_dir'));
  if ($('#soloNoLiquidados').checked) params.append('solo_no_liquidados', '1');

  if ([...params].length === 0) {
    $('#tbody').innerHTML = '';
    return;
  }

  const endpoint = `${API_BASE}/proyectos?${params.toString()}`;
  const res = await fetch(endpoint);
  if (!res.ok) return toast('Error cargando proyectos', 'danger');
  const data = await res.json();
  renderTable(data);
}

// ===== Render tabla con Vincular Usuarios
function renderTable(data) {
  const tbody = $('#tbody');
  tbody.innerHTML = '';

  (data.data || []).forEach(p => {
    const certificadoBtn = p.certificado
  ? `<a class="btn btn-sm btn-outline-secondary"
         href="${API_BASE}/proyectos/${p.ID_Proyecto}/descargar-certificado"
         target="_blank"
         download>
       <i class="bi bi-download"></i> Descargar
     </a>`
  : `<button class="btn btn-sm btn-outline-secondary" disabled title="No hay certificado disponible">
       <i class="bi bi-download"></i> Descargar
     </button>`;


    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${p.ID_Proyecto}</td>
      <td>${p.nombre ?? ''}</td>
      <td>${p.fecha ?? ''}</td>
      <td>${p.descripcion ?? ''}</td>
      <td>${p.certificado ?? ''}</td>
      <td class="text-end">
        <div class="btn-group">
          <button class="btn btn-sm btn-outline-primary" onclick='openEdit(${JSON.stringify(p)})'>
            <i class="bi bi-pencil-square"></i> Editar
          </button>
          ${certificadoBtn}
          <button class="btn btn-sm btn-outline-success" onclick='openVincular(${p.ID_Proyecto})'>
            <i class="bi bi-person-plus"></i> Vincular Usuarios
          </button>
        </div>
      </td>
    `;
    tbody.appendChild(tr);
  });

  if (!data.data || data.data.length === 0) {
    const tr = document.createElement('tr');
    tr.innerHTML = `<td colspan="6" class="text-center text-muted">No hay proyectos que coincidan con los filtros.</td>`;
    tbody.appendChild(tr);
  }
}

// ===== Crear / Editar proyecto
const modalProyecto = new bootstrap.Modal('#modalProyecto');
$('#btnNuevo').addEventListener('click', () => {
  $('#titleProyecto').textContent = 'Nuevo proyecto';
  $('#_id').value = '';
  $('#formProyecto').reset();
  modalProyecto.show();
});

function openEdit(p) {
  $('#titleProyecto').textContent = 'Editar proyecto';
  $('#_id').value = p.ID_Proyecto;
  $('#formProyecto').nombre.value = p.nombre || '';
  $('#formProyecto').fecha.value = p.fecha || '';
  $('#formProyecto').descripcion.value = p.descripcion || '';
  $('#formProyecto').certificado.value = '';
  modalProyecto.show();
}

$('#formProyecto').addEventListener('submit', async (e) => {
  e.preventDefault();
  const id = $('#_id').value;
  const form = new FormData(e.target);
  if (id) form.append('_method','PUT');

  const res = await fetch(id ? `${API_BASE}/proyectos/${id}` : `${API_BASE}/proyectos`, {
    method: 'POST',
    body: form
  });

  if (!res.ok) {
    const err = await safeJson(res);
    toast(err?.message || 'Error guardando', 'danger');
    return;
  }

  toast('Guardado con éxito');
  modalProyecto.hide();
  loadProyectos();
});

async function safeJson(res) {
  try { return await res.json(); } catch { return null; }
}

// ===== Filtros
$('#formFiltros').addEventListener('submit', (e) => {
  e.preventDefault();
  loadProyectos();
});

$('#btnLimpiar').addEventListener('click', () => {
  $('#formFiltros').reset();
  $('#tbody').innerHTML = '';
});

// ===== Modal Vincular Usuarios
const modalVincular = new bootstrap.Modal('#modalVincular');

function openVincular(ID_Proyecto) {
  $('#vincular_ID_Proyecto').value = ID_Proyecto;
  const list = $('#usuariosList');
  list.innerHTML = '<div class="text-center text-muted">Cargando...</div>';

  fetch(`${API_BASE}/usuarios`)  // Devuelve todos los usuarios
    .then(r => r.json())
    .then(data => {
      list.innerHTML = '';
      data.forEach(u => {
        const item = document.createElement('div');
        item.className = 'form-check';
        item.innerHTML = `
          <input class="form-check-input" type="checkbox" value="${u.ID_Usuario}" id="user_${u.ID_Usuario}">
          <label class="form-check-label" for="user_${u.ID_Usuario}">${u.Nombre} ${u.Apellido}</label>
        `;
        list.appendChild(item);
      });
    });

  modalVincular.show();
}

$('#formVincularUsuarios').addEventListener('submit', async (e) => {
  e.preventDefault();
  const ID_Proyecto = $('#vincular_ID_Proyecto').value;
  const selected = [...$('#usuariosList input:checked')].map(i => i.value);

  const res = await fetch(`${API_BASE}/proyectos/${ID_Proyecto}/usuarios`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ ids: selected })
  });

  if (!res.ok) return toast('Error vinculando usuarios', 'danger');
  toast('Usuarios vinculados exitosamente');
  modalVincular.hide();
});

// ===== Tabla vacía al inicio
$('#tbody').innerHTML = '';
</script>
</body>
</html>

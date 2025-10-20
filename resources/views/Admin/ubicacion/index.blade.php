@extends('admin.layouts.app')

@section('title', 'Ubicaciones')

@section('content')
<div class="container-fluid py-3">
  <h4 class="mb-3">Ubicaciones</h4>

  {{-- FILTROS --}}
  <div class="card mb-3">
    <div class="card-body">
      <div class="row g-2">
        <div class="col-sm-4">
          <select id="fPais" class="form-select form-select-sm">
            <option value="">Seleccione País</option>
          </select>
        </div>
        <div class="col-sm-4">
          <select id="fDep" class="form-select form-select-sm">
            <option value="">Seleccione Departamento</option>
          </select>
        </div>
        <div class="col-sm-4">
          <select id="fMun" class="form-select form-select-sm">
            <option value="">Seleccione Municipio</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  {{-- TABLA DE UBICACIONES --}}
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span class="fw-semibold">Ubicaciones Registradas</span>
      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#mdlUbicacion">
        <i class="bi bi-plus-lg me-1"></i> Nueva ubicación
      </button>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
          <thead>
            <tr>
              <th>País</th>
              <th>Departamento</th>
              <th>Municipio</th>
              <th>Dirección</th>
              <th class="text-end">Acciones</th>
            </tr>
          </thead>
          <tbody id="tbUbicaciones"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- MODAL UBICACION --}}
<div class="modal fade" id="mdlUbicacion" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" onsubmit="guardarUbicacion(event)">
      <div class="modal-header">
        <h5 class="modal-title">Ubicación</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="ubicacionId">
        <div class="mb-2">
          <label class="form-label">País</label>
          <select id="selPais" class="form-select" required>
            <option value="">Seleccione País</option>
          </select>
        </div>
        <div class="mb-2">
          <label class="form-label">Departamento</label>
          <select id="selDep" class="form-select" required>
            <option value="">Seleccione Departamento</option>
          </select>
        </div>
        <div class="mb-2">
          <label class="form-label">Municipio</label>
          <select id="selMun" class="form-select" required>
            <option value="">Seleccione Municipio</option>
          </select>
        </div>
        <div class="mb-2">
          <label class="form-label">Dirección</label>
          <input id="direccion" type="text" class="form-control" placeholder="Ej: Calle 123 #45-67">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" type="submit">Guardar</button>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script>
const API = '/api';

// === UTILIDADES ===
const createOpt = (text,val)=>{const o=document.createElement('option'); o.textContent=text; o.value=val; return o;};
const showToast=(msg,type='success')=>{
  const t=document.createElement('div');
  t.className=`toast align-items-center text-bg-${type} border-0 position-fixed bottom-0 end-0 m-3`;
  t.innerHTML=`<div class="d-flex"><div class="toast-body">${msg}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>`;
  document.body.appendChild(t);
  new bootstrap.Toast(t,{delay:3000}).show();
  t.addEventListener('hidden.bs.toast',()=>t.remove());
};

// === CARGAR SELECTS ===
async function cargarSelects(){
  const paises=await (await fetch(`${API}/paises`)).json();
  const selPais=document.getElementById('selPais');
  const fPais=document.getElementById('fPais');
  selPais.innerHTML=fPais.innerHTML='';
  selPais.appendChild(createOpt('Seleccione País',''));
  fPais.appendChild(createOpt('Todos',''));
  paises.forEach(p=>{
    selPais.appendChild(createOpt(p.Nombre,p.ID_Pais));
    fPais.appendChild(createOpt(p.Nombre,p.ID_Pais));
  });
}

// === DEPENDENCIAS ===
async function cargarDepartamentos(paisId, targetSelect){
  targetSelect.innerHTML='';
  targetSelect.appendChild(createOpt('Seleccione Departamento',''));
  if(!paisId) return;
  const deps=await (await fetch(`${API}/departamentos?pais=${paisId}`)).json();
  deps.forEach(d=>targetSelect.appendChild(createOpt(d.Nombre,d.ID_Departamento)));
}

async function cargarMunicipios(depId, targetSelect){
  targetSelect.innerHTML='';
  targetSelect.appendChild(createOpt('Seleccione Municipio',''));
  if(!depId) return;
  const muns=await (await fetch(`${API}/municipios?departamento=${depId}`)).json();
  muns.forEach(m=>targetSelect.appendChild(createOpt(m.Nombre,m.ID_Municipio)));
}

// === EVENTOS MODAL ===
document.getElementById('selPais').addEventListener('change',async function(){
  await cargarDepartamentos(this.value, document.getElementById('selDep'));
  document.getElementById('selMun').innerHTML=createOpt('Seleccione Municipio','').outerHTML;
});

document.getElementById('selDep').addEventListener('change',async function(){
  await cargarMunicipios(this.value, document.getElementById('selMun'));
});

// === EVENTOS FILTROS ===
document.getElementById('fPais').addEventListener('change',async function(){
  await cargarDepartamentos(this.value, document.getElementById('fDep'));
  document.getElementById('fMun').innerHTML=createOpt('Seleccione Municipio','').outerHTML;
  cargarUbicaciones();
});

document.getElementById('fDep').addEventListener('change',async function(){
  cargarMunicipios(this.value, document.getElementById('fMun'));
  cargarUbicaciones();
});

document.getElementById('fMun').addEventListener('change',cargarUbicaciones);

// === CARGAR TABLA ===
async function cargarUbicaciones(){
  let url=`${API}/ubicaciones?`;
  const paisId=document.getElementById('fPais').value;
  const depId=document.getElementById('fDep').value;
  const munId=document.getElementById('fMun').value;
  if(paisId) url+=`pais=${paisId}&`;
  if(depId) url+=`departamento=${depId}&`;
  if(munId) url+=`municipio=${munId}&`;
  const data=await (await fetch(url)).json();
  const tb=document.getElementById('tbUbicaciones');
  tb.innerHTML='';
  data.data.forEach(u=>{
    tb.innerHTML+=`<tr>
      <td>${u.pais?.Nombre||''}</td>
      <td>${u.departamento?.Nombre||''}</td>
      <td>${u.municipio?.Nombre||''}</td>
      <td>${u.direccion||''}</td>
      <td class="text-end">
        <button class="btn btn-sm btn-warning me-1" onclick="editarUb(${u.ID_Ubicacion})">Editar</button>
        <button class="btn btn-sm btn-danger" onclick="eliminarUb(${u.ID_Ubicacion})">Eliminar</button>
      </td>
    </tr>`;
  });
}

// === FUNCIONES CRUD ===
async function guardarUbicacion(e){
  e.preventDefault();
  const id=document.getElementById('ubicacionId').value;
  const payload={
    FK_ID_Pais: document.getElementById('selPais').value,
    FK_ID_Departamento: document.getElementById('selDep').value,
    FK_ID_Municipio: document.getElementById('selMun').value,
    direccion: document.getElementById('direccion').value
  };
  const method=id?'PUT':'POST';
  const url=id?`${API}/ubicaciones/${id}`:`${API}/ubicaciones`;
  const res=await fetch(url,{method,headers:{'Content-Type':'application/json'},body:JSON.stringify(payload)});
  const data=await res.json();
  if(res.ok){
    showToast(data.message);
    cargarUbicaciones();
    document.getElementById('mdlUbicacion').querySelector('form').reset();
    bootstrap.Modal.getInstance(document.getElementById('mdlUbicacion')).hide();
  } else {
    showToast(data.message||'Error','danger');
  }
}

async function editarUb(id){
  const data=await (await fetch(`${API}/ubicaciones/${id}`)).json();
  document.getElementById('ubicacionId').value=data.ID_Ubicacion;
  document.getElementById('direccion').value=data.direccion;
  document.getElementById('selPais').value=data.FK_ID_Pais;
  await cargarDepartamentos(data.FK_ID_Pais, document.getElementById('selDep'));
  document.getElementById('selDep').value=data.FK_ID_Departamento;
  await cargarMunicipios(data.FK_ID_Departamento, document.getElementById('selMun'));
  document.getElementById('selMun').value=data.FK_ID_Municipio;
  new bootstrap.Modal(document.getElementById('mdlUbicacion')).show();
}

async function eliminarUb(id){
  if(!confirm('¿Eliminar ubicación?')) return;
  const res=await fetch(`${API}/ubicaciones/${id}`,{method:'DELETE'});
  const data=await res.json();
  if(res.ok){
    showToast(data.message);
    cargarUbicaciones();
  } else showToast(data.message||'Error','danger');
}

// === INICIALIZACION ===
cargarSelects().then(cargarUbicaciones);
</script>
@endpush

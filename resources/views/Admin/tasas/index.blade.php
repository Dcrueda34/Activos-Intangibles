@extends('layouts.app')

@section('title','Tasas')
@section('page-title','Tasas de interés')

@section('content')
<div class="card shadow-sm">
  <div class="card-body">
    <form id="tasasForm" onsubmit="event.preventDefault(); validarGuardar();">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Tasa Libre de Riesgo EEUU</label>
          <input id="tlr" type="number" class="form-control" placeholder="%">
          <input id="tlr2" class="form-control mt-1" readonly placeholder="%">
        </div>
        <div class="col-md-6">
          <label class="form-label">Tasa libre de riesgo Colombia</label>
          <input id="tlrc" type="number" class="form-control" placeholder="%">
          <input id="tlrc2" class="form-control mt-1" readonly placeholder="%">
        </div>
        <div class="col-md-6">
          <label class="form-label">Retorno S&P 500</label>
          <input id="rsyp" type="number" class="form-control" placeholder="%">
          <input id="rsyp2" class="form-control mt-1" readonly placeholder="%">
        </div>
        <div class="col-md-6">
          <label class="form-label">Beta Desapalancado</label>
          <input id="bd" type="number" class="form-control">
          <input id="bd2" class="form-control mt-1" readonly>
        </div>

        <div class="col-md-4">
          <label class="form-label">Tasa de impuestos</label>
          <input id="tdi" type="number" class="form-control" placeholder="%">
          <input id="tdi2" class="form-control mt-1" readonly placeholder="%">
        </div>
        <div class="col-md-4">
          <label class="form-label">Activo</label>
          <input id="a" type="number" class="form-control">
          <input id="a2" class="form-control mt-1" readonly>
        </div>
        <div class="col-md-4">
          <label class="form-label">Deuda</label>
          <input id="d" type="number" class="form-control">
          <input id="d2" class="form-control mt-1" readonly>
        </div>

        <div class="col-md-4">
          <label class="form-label">Patrimonio</label>
          <input id="p" type="number" class="form-control">
          <input id="p2" class="form-control mt-1" readonly>
        </div>
        <div class="col-md-4">
          <label class="form-label">Devaluación esperada</label>
          <input id="de" type="number" class="form-control" placeholder="%">
          <input id="de2" class="form-control mt-1" readonly placeholder="%">
        </div>
        <div class="col-md-4">
          <label class="form-label">Prima por tamaño</label>
          <input id="ppt" type="number" class="form-control" placeholder="%">
          <input id="ppt2" class="form-control mt-1" readonly placeholder="%">
        </div>

        {{-- Resultados claves --}}
        <div class="col-md-4">
          <label class="form-label">Tasa descuento ajustada (tddaar)</label>
          <input id="tddaar2" class="form-control" readonly placeholder="%">
        </div>
        <div class="col-md-4">
          <label class="form-label">Costo deuda después impuestos</label>
          <input id="cdddi2" class="form-control" readonly placeholder="%">
        </div>
        <div class="col-md-4">
          <label class="form-label">Costo exigido en pesos (Ke)</label>
          <input id="cepeiep2" class="form-control" readonly placeholder="%">
        </div>
      </div>

      <div class="d-flex gap-2 mt-4">
        <button class="btn btn-primary">
          <i class="bi bi-save"></i> Guardar
        </button>
        <button type="button" class="btn btn-outline-secondary" onclick="cargarLocal()">
          <i class="bi bi-cloud-download"></i> Cargar últimos
        </button>
        <button type="button" class="btn btn-outline-danger" onclick="localStorage.clear();showToast('Datos locales borrados','warning')">
          <i class="bi bi-trash"></i> Borrar locales
        </button>
      </div>
    </form>

    <hr class="my-4">

    <h5 class="mb-3">📊 Historial de Tasas Guardadas</h5>

    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle" id="tablaTasas">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Tasa (%)</th>
            <th>Fecha</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr><td colspan="4" class="text-center text-muted">Cargando...</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>

const API = '/api';

// 🔹 Función para convertir a porcentaje decimal
function pct(x){ return (parseFloat(x)||0)/100; }

// 🔹 Validar y guardar (local + servidor)
function validarGuardar(){
  calcular();
  guardarLocal();
  guardarServidor();
}

// 🔹 Cálculo principal
function calcular(){
  const tlrVal=pct(tlr.value), tlrcVal=pct(tlrc.value), rsypVal=pct(rsyp.value),
        bdVal=parseFloat(bd.value)||0, tdiVal=pct(tdi.value),
        aVal=parseFloat(a.value)||0, dVal=parseFloat(d.value)||0, pVal=parseFloat(p.value)||0,
        deVal=pct(de.value), pptVal=pct(ppt.value);

  const rp = tlrcVal - tlrVal;
  const pdm = rsypVal - tlrcVal;
  const da = aVal ? dVal/aVal : 0;
  const pa = aVal ? pVal/aVal : 0;
  const dp = pVal ? dVal/pVal : 0;

  const ba = bdVal * (1 + (dp * (1 - tdiVal)));
  const cepi = tlrVal + ba * pdm + rp;
  const cepiep = (1 + cepi) * (1 + deVal) - 1;
  const cepeiep = cepiep + pptVal;
  const cdddi = (pct(document.getElementById('cdadi')?.value||0)) * (1 - tdiVal);
  const tdd = pa * cepeiep + da * cdddi;
  const tddaar = tdd + pct(document.getElementById('sda')?.value||0);

  // 🔹 Mostrar resultados en sus campos secundarios
  tlr2.value = (tlrVal*100).toFixed(2)+'%';
  tlrc2.value = (tlrcVal*100).toFixed(2)+'%';
  rsyp2.value = (rsypVal*100).toFixed(2)+'%';
  bd2.value = bdVal.toFixed(2);
  tdi2.value = (tdiVal*100).toFixed(2)+'%';
  a2.value = aVal.toFixed(0);
  d2.value = dVal.toFixed(0);
  p2.value = pVal.toFixed(0);
  de2.value = (deVal*100).toFixed(2)+'%';
  ppt2.value= (pptVal*100).toFixed(2)+'%';
  cdddi2.value=(cdddi*100).toFixed(2)+'%';
  cepeiep2.value=(cepeiep*100).toFixed(2)+'%';
  tddaar2.value=(tddaar*100).toFixed(2)+'%';

  showToast('✅ Cálculo actualizado correctamente','info');
}

// 🔹 Guardar datos localmente
function guardarLocal(){
  const ids=['tlr','tlrc','rsyp','bd','tdi','a','d','p','de','ppt'];
  ids.forEach(id=>{
    localStorage.setItem('tasas:'+id, document.getElementById(id)?.value ?? '');
  });
  showToast('💾 Datos guardados localmente','success');
}

// 🔹 Cargar desde localStorage
function cargarLocal(){
  const ids=['tlr','tlrc','rsyp','bd','tdi','a','d','p','de','ppt'];
  ids.forEach(id=>{
    const v=localStorage.getItem('tasas:'+id);
    if(v!==null) document.getElementById(id).value=v;
  });
  calcular();
  showToast('☁️ Datos locales cargados','info');
}

// 🔹 Cargar última tasa desde servidor
async function cargarUltimaServidor(){
  try{
    const r = await fetch(`${API}/tasas/ultima`);
    if (!r.ok) return;
    const data = await r.json();
    if (data && (data.tasa || data.Tasa)) {
      document.getElementById('tddaar2').value = (data.tasa || data.Tasa) + '%';
      showToast('🌐 Tasa cargada desde servidor','success');
    }
  }catch(e){
    console.error('Error al cargar tasa del servidor', e);
  }
}

// 🔹 Guardar tasa final en el servidor
async function guardarServidor(){
  const tddaar = tddaar2.value.replace('%','');
  try{
    const r = await fetch(`${API}/tasas`,{
      method:'POST',
      headers:{'Accept':'application/json'},
      body: (()=>{ const fd=new FormData(); fd.append('tasa',tddaar); return fd; })()
    });
    if(!r.ok) return showToast('⚠️ Guardado local; no se pudo registrar en servidor','warning');
    showToast('🚀 Tasa guardada en servidor','success');
    cargarTasas();
  }catch(e){ showToast('❌ Error de red al guardar','danger'); }
}

// 🔹 Cargar historial de tasas
async function cargarTasas(){
  try{
    const r = await fetch(`${API}/tasas`);
    const data = await r.json();
    const tbody = document.querySelector("#tablaTasas tbody");
    tbody.innerHTML = "";

    if (!data || data.length === 0) {
      tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">No hay tasas registradas</td></tr>`;
      return;
    }

    data.forEach(t => {
      tbody.innerHTML += `
        <tr>
          <td>${t.id}</td>
          <td>${parseFloat(t.tasa).toFixed(2)}%</td>
          <td>${t.fecha ?? 'Sin fecha'}</td>
          <td>
            <button class="btn btn-sm btn-danger" onclick="eliminarTasa(${t.id})">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        </tr>
      `;
    });
  } catch (e) {
    console.error('Error al cargar tasas:', e);
  }
}

// 🔹 Eliminar tasa del servidor
async function eliminarTasa(id){
  if(!confirm('¿Seguro que deseas eliminar esta tasa?')) return;
  try{
    const r = await fetch(`${API}/tasas/${id}`,{method:'DELETE'});
    if(r.ok){
      showToast('🗑️ Tasa eliminada correctamente','success');
      cargarTasas();
    }else{
      showToast('❌ Error al eliminar tasa','danger');
    }
  }catch(e){
    showToast('⚠️ Error de red al eliminar','danger');
  }
}

// 🔹 Iniciar todo al cargar
document.addEventListener('DOMContentLoaded',()=>{
  cargarLocal();
  cargarUltimaServidor();
  cargarTasas();
});
</script>
@endpush

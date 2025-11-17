let ctCurrentPage = 1;
let ctItemsPerPage = 10;
let ctTotalPages = 0;

document.addEventListener('DOMContentLoaded', function() {
  const hoy = new Date();
  const hace30 = new Date();
  hace30.setDate(hoy.getDate() - 30);
  const dDesde = document.getElementById('ct_fechaDesde');
  const dHasta = document.getElementById('ct_fechaHasta');
  dDesde && (dDesde.value = hace30.toISOString().split('T')[0]);
  dHasta && (dHasta.value = hoy.toISOString().split('T')[0]);

  const btnBuscar = document.getElementById('ct_btnBuscar');
  const btnLimpiar = document.getElementById('ct_btnLimpiar');
  const btnLeidos = document.getElementById('ct_marcarLeidos');
  const btnNoLeidos = document.getElementById('ct_marcarNoLeidos');
  const btnEliminar = document.getElementById('ct_eliminar');
  const btnCSV = document.getElementById('ct_exportarCSV');
  const selectAll = document.getElementById('ct_selectAll');

  btnBuscar && btnBuscar.addEventListener('click', function(){ ctCurrentPage = 1; cargarContactos(); });
  btnLimpiar && btnLimpiar.addEventListener('click', function(){ limpiarFiltrosContactos(); });
  btnLeidos && btnLeidos.addEventListener('click', function(){ actualizarEstadoSeleccion('leido'); });
  btnNoLeidos && btnNoLeidos.addEventListener('click', function(){ actualizarEstadoSeleccion('no_leido'); });
  btnEliminar && btnEliminar.addEventListener('click', function(){ eliminarSeleccionados(); });
  btnCSV && btnCSV.addEventListener('click', function(){ exportarCSVContactos(); });
  selectAll && selectAll.addEventListener('change', function(){ seleccionarTodos(this.checked); });

  cargarContactos();
});

function filtrosQuery() {
  const fDesde = document.getElementById('ct_fechaDesde').value || '';
  const fHasta = document.getElementById('ct_fechaHasta').value || '';
  const estado = document.getElementById('ct_estado').value || '';
  const q = document.getElementById('ct_q').value || '';
  const params = new URLSearchParams();
  params.set('page', ctCurrentPage);
  params.set('items_per_page', ctItemsPerPage);
  params.set('date_from', fDesde);
  params.set('date_to', fHasta);
  params.set('estado', estado);
  params.set('q', q);
  return params.toString();
}

function cargarContactos() {
  const tabla = document.getElementById('ct_tabla');
  if (tabla) tabla.innerHTML = '<tr><td colspan="8" class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Cargando...</span></div></td></tr>';
  fetch('/phpserv/get_contactos.php?' + filtrosQuery(), { credentials: 'same-origin' })
    .then(r => { if (!r.ok) throw new Error('Error al cargar'); return r.json(); })
    .then(data => {
      mostrarContactos(data.data.registros || []);
      ctTotalPages = data.data.total_pages || 0;
      actualizarPaginacionContactos();
    })
    .catch(e => { alert('No se pudieron cargar los mensajes: ' + e.message); });
}

function mostrarContactos(registros) {
  const tbody = document.getElementById('ct_tabla');
  tbody.innerHTML = '';
  if (!registros || registros.length === 0) {
    tbody.innerHTML = '<tr><td colspan="8" class="text-center">No se encontraron mensajes</td></tr>';
    return;
  }
  registros.forEach(r => {
    const tr = document.createElement('tr');
    const chk = document.createElement('input');
    chk.type = 'checkbox';
    chk.className = 'ct-row-check';
    chk.dataset.id = r.idcontacto;
    const td0 = document.createElement('td'); td0.appendChild(chk);
    const td1 = document.createElement('td'); td1.textContent = r.nombre;
    const td2 = document.createElement('td'); td2.textContent = r.email;
    const td3 = document.createElement('td'); td3.textContent = r.asunto;
    const td4 = document.createElement('td'); td4.textContent = r.mensaje;
    const td5 = document.createElement('td'); td5.textContent = r.fecha + ' ' + r.hora;
    const estadoVal = r.estado || 'no_leido';
    const td6 = document.createElement('td'); td6.textContent = estadoVal;
    const td7 = document.createElement('td');
    const btnToggle = document.createElement('button');
    btnToggle.className = 'btn btn-sm ' + (estadoVal === 'leido' ? 'btn-warning' : 'btn-success');
    btnToggle.textContent = estadoVal === 'leido' ? 'Marcar no leído' : 'Marcar leído';
    btnToggle.addEventListener('click', function(){ actualizarEstado([r.idcontacto], estadoVal === 'leido' ? 'no_leido' : 'leido'); });
    const btnDel = document.createElement('button');
    btnDel.className = 'btn btn-sm btn-danger ms-2';
    btnDel.textContent = 'Eliminar';
    btnDel.addEventListener('click', function(){ eliminarPorIds([r.idcontacto]); });
    td7.appendChild(btnToggle);
    td7.appendChild(btnDel);
    tr.appendChild(td0);
    tr.appendChild(td1);
    tr.appendChild(td2);
    tr.appendChild(td3);
    tr.appendChild(td4);
    tr.appendChild(td5);
    tr.appendChild(td6);
    tr.appendChild(td7);
    tbody.appendChild(tr);
  });
}

function actualizarPaginacionContactos() {
  const pag = document.getElementById('ct_paginacion');
  pag.innerHTML = '';
  if (ctTotalPages <= 1) return;
  const btnAnt = document.createElement('li');
  btnAnt.className = 'page-item ' + (ctCurrentPage === 1 ? 'disabled' : '');
  const linkAnt = document.createElement('a'); linkAnt.className = 'page-link'; linkAnt.href = '#'; linkAnt.textContent = 'Anterior';
  linkAnt.addEventListener('click', function(e){ e.preventDefault(); if (ctCurrentPage > 1) { ctCurrentPage--; cargarContactos(); } });
  btnAnt.appendChild(linkAnt); pag.appendChild(btnAnt);
  let startPage = Math.max(1, ctCurrentPage - 2);
  let endPage = Math.min(ctTotalPages, startPage + 4);
  if (endPage - startPage < 4) startPage = Math.max(1, endPage - 4);
  if (startPage > 1) {
    const btnFirst = document.createElement('li'); btnFirst.className = 'page-item';
    const linkFirst = document.createElement('a'); linkFirst.className = 'page-link'; linkFirst.href = '#'; linkFirst.textContent = '1';
    linkFirst.addEventListener('click', function(e){ e.preventDefault(); ctCurrentPage = 1; cargarContactos(); });
    btnFirst.appendChild(linkFirst); pag.appendChild(btnFirst);
    if (startPage > 2) { const el = document.createElement('li'); el.className = 'page-item disabled'; const lk = document.createElement('a'); lk.className = 'page-link'; lk.href = '#'; lk.textContent = '...'; el.appendChild(lk); pag.appendChild(el); }
  }
  for (let i = startPage; i <= endPage; i++) {
    const li = document.createElement('li'); li.className = 'page-item ' + (i === ctCurrentPage ? 'active' : '');
    const a = document.createElement('a'); a.className = 'page-link'; a.href = '#'; a.textContent = i;
    a.addEventListener('click', function(e){ e.preventDefault(); ctCurrentPage = i; cargarContactos(); });
    li.appendChild(a); pag.appendChild(li);
  }
  if (endPage < ctTotalPages) {
    if (endPage < ctTotalPages - 1) { const el2 = document.createElement('li'); el2.className = 'page-item disabled'; const lk2 = document.createElement('a'); lk2.className = 'page-link'; lk2.href = '#'; lk2.textContent = '...'; el2.appendChild(lk2); pag.appendChild(el2); }
    const btnLast = document.createElement('li'); btnLast.className = 'page-item';
    const linkLast = document.createElement('a'); linkLast.className = 'page-link'; linkLast.href = '#'; linkLast.textContent = ctTotalPages;
    linkLast.addEventListener('click', function(e){ e.preventDefault(); ctCurrentPage = ctTotalPages; cargarContactos(); });
    btnLast.appendChild(linkLast); pag.appendChild(btnLast);
  }
  const btnSig = document.createElement('li'); btnSig.className = 'page-item ' + (ctCurrentPage === ctTotalPages ? 'disabled' : '');
  const linkSig = document.createElement('a'); linkSig.className = 'page-link'; linkSig.href = '#'; linkSig.textContent = 'Siguiente';
  linkSig.addEventListener('click', function(e){ e.preventDefault(); if (ctCurrentPage < ctTotalPages) { ctCurrentPage++; cargarContactos(); } });
  btnSig.appendChild(linkSig); pag.appendChild(btnSig);
}

function limpiarFiltrosContactos() {
  const hoy = new Date();
  const hace30 = new Date();
  hace30.setDate(hoy.getDate() - 30);
  document.getElementById('ct_fechaDesde').value = hace30.toISOString().split('T')[0];
  document.getElementById('ct_fechaHasta').value = hoy.toISOString().split('T')[0];
  document.getElementById('ct_estado').value = '';
  document.getElementById('ct_q').value = '';
  ctCurrentPage = 1;
  cargarContactos();
}

function getSelectedIds() {
  const checks = document.querySelectorAll('.ct-row-check');
  const ids = [];
  checks.forEach(c => { if (c.checked) ids.push(parseInt(c.dataset.id, 10)); });
  return ids;
}

function seleccionarTodos(checked) {
  document.querySelectorAll('.ct-row-check').forEach(c => { c.checked = checked; });
}

function actualizarEstadoSeleccion(estado) {
  const ids = getSelectedIds();
  if (ids.length === 0) { alert('Seleccione al menos un mensaje'); return; }
  actualizarEstado(ids, estado);
}

function actualizarEstado(ids, estado) {
  fetch('/phpserv/update_contactos_estado.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ ids: ids, estado: estado })
  }).then(r => { if (!r.ok) throw new Error('Error al actualizar estado'); return r.json(); })
    .then(() => { cargarContactos(); })
    .catch(e => { alert('No se pudo actualizar: ' + e.message); });
}

function eliminarSeleccionados() {
  const ids = getSelectedIds();
  if (ids.length === 0) { alert('Seleccione al menos un mensaje'); return; }
  if (!confirm('¿Desea eliminar los mensajes seleccionados?')) return;
  eliminarPorIds(ids);
}

function eliminarPorIds(ids) {
  fetch('/phpserv/eliminar_contactos.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ ids: ids })
  }).then(r => { if (!r.ok) throw new Error('Error al eliminar'); return r.json(); })
    .then(() => { cargarContactos(); })
    .catch(e => { alert('No se pudo eliminar: ' + e.message); });
}

function exportarCSVContactos() {
  const url = '/phpserv/exportar_contactos_csv.php?' + filtrosQuery();
  fetch(url)
    .then(r => { if (!r.ok) throw new Error('Error al exportar'); return r.blob(); })
    .then(blob => {
      const a = document.createElement('a');
      const u = window.URL.createObjectURL(blob);
      a.href = u; a.download = 'contactos.csv'; a.style.display = 'none';
      document.body.appendChild(a); a.click();
      window.URL.revokeObjectURL(u); document.body.removeChild(a);
    })
    .catch(e => { alert('No se pudo exportar: ' + e.message); });
}
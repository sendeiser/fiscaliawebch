// Variables globales para paginación y filtros
let currentPage = 1;
let itemsPerPage = 10;
let totalPages = 0;

// Inicializar cuando el documento esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Cargar estadísticas y auditoría al cargar la página
    cargarEstadisticas();
    cargarAuditoria();

    // Configurar listeners para botones
    document.getElementById('btnRefrescar').addEventListener('click', function() {
        cargarEstadisticas();
        cargarAuditoria();
    });

    document.getElementById('btnExportarCSV').addEventListener('click', exportarCSV);
    document.getElementById('btnExportarPDF').addEventListener('click', exportarPDF);
    document.getElementById('btnAplicarFiltros').addEventListener('click', aplicarFiltros);
    document.getElementById('btnLimpiarFiltros').addEventListener('click', limpiarFiltros);

    // Pre-llenar fechas para los últimos 30 días por defecto
    const hoy = new Date();
    const hace30Dias = new Date();
    hace30Dias.setDate(hoy.getDate() - 30);

    document.getElementById('fechaDesde').value = hace30Dias.toISOString().split('T')[0];
    document.getElementById('fechaHasta').value = hoy.toISOString().split('T')[0];
});

/**
 * Carga las estadísticas de auditoría
 */
function cargarEstadisticas() {
    fetch('phpserv/get_estadisticas_auditoria.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar estadísticas');
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data); // Agregar log para depuración
            
            // Verificar que data.data existe
            if (!data || !data.data) {
                throw new Error('Formato de respuesta inválido');
            }
            
            // Actualizar las tarjetas de estadísticas
            document.getElementById('totalOperaciones').textContent = data.data.total_operaciones || '0';
            document.getElementById('operacionesInsert').textContent = (data.data.total_informes != null ? data.data.total_informes : data.data.total_inserciones) || '0';
            document.getElementById('operacionesUpdate').textContent = data.data.total_actualizaciones || '0';
            document.getElementById('operacionesDelete').textContent = data.data.total_eliminaciones || '0';

            // Mostrar las tablas más afectadas
            const tablasMasAfectadas = document.getElementById('tablasMasAfectadas');
            tablasMasAfectadas.innerHTML = '';
            
            // Verificar que tablas_afectadas existe y es un array
            if (data.data.tablas_afectadas && Array.isArray(data.data.tablas_afectadas)) {
                data.data.tablas_afectadas.forEach(tabla => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center';
                    li.textContent = tabla.tabla;
                    
                    const badge = document.createElement('span');
                    badge.className = 'badge bg-primary rounded-pill';
                    badge.textContent = tabla.total; // Cambiar cantidad por total
                    
                    li.appendChild(badge);
                    tablasMasAfectadas.appendChild(li);
                });
            } else {
                // Si no hay tablas afectadas, mostrar mensaje
                const li = document.createElement('li');
                li.className = 'list-group-item text-center';
                li.textContent = 'No hay datos disponibles';
                tablasMasAfectadas.appendChild(li);
            }
        })
        .catch(error => {
            mostrarError('Error', 'No se pudieron cargar las estadísticas: ' + error.message);
        });
}

/**
 * Carga los registros de auditoría con paginación y filtros
 */
function cargarAuditoria() {
    // Obtener valores de filtros
    const fechaDesde = document.getElementById('fechaDesde').value;
    const fechaHasta = document.getElementById('fechaHasta').value;
    const tabla = document.getElementById('filtroTabla').value;
    const operacion = document.getElementById('filtroOperacion').value;
    const usuario = document.getElementById('filtroUsuario').value;
    const expediente = document.getElementById('filtroExpediente').value;
    const dni = document.getElementById('filtroDNI').value;

    // Mostrar indicador de carga
    document.getElementById('tablaAuditoria').innerHTML = '<tr><td colspan="8" class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Cargando...</span></div></td></tr>';

    // Realizar petición AJAX
    fetch(`phpserv/get_auditoria.php?page=${currentPage}&items_per_page=${itemsPerPage}&date_from=${fechaDesde}&date_to=${fechaHasta}&tabla=${tabla}&operacion=${operacion}&usuario=${usuario}&expediente=${expediente}&dni=${dni}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar auditoría');
            }
            return response.json();
        })
        .then(data => {
            mostrarAuditoria(data.data.registros);
            totalPages = data.data.total_pages;
            actualizarPaginacion();
        })
        .catch(error => {
            mostrarError('Error', 'No se pudieron cargar los registros de auditoría: ' + error.message);
        });
}

/**
 * Muestra los registros de auditoría en la tabla
 */
function mostrarAuditoria(registros) {
    const tabla = document.getElementById('tablaAuditoria');
    tabla.innerHTML = '';

    if (registros.length === 0) {
        tabla.innerHTML = '<tr><td colspan="8" class="text-center">No se encontraron registros</td></tr>';
        return;
    }

    registros.forEach(registro => {
        const fila = document.createElement('tr');
        
        // Crear celdas para cada columna
    const columnas = [
        registro.id,
        registro.fecha + ' ' + registro.hora,
        registro.usuario,
        (registro.rol || '-'),
        registro.tabla_afectada,
        registro.operacion,
        registro.num_expediente || '-',
        (registro.nombre || registro.usuario || '-')
    ];

        columnas.forEach(texto => {
            const celda = document.createElement('td');
            celda.textContent = texto;
            fila.appendChild(celda);
        });
        
        tabla.appendChild(fila);
    });
}

/**
 * Actualiza los controles de paginación
 */
function actualizarPaginacion() {
    const paginacion = document.getElementById('paginacion');
    paginacion.innerHTML = '';

    // Si no hay páginas, no mostrar paginación
    if (totalPages <= 1) {
        return;
    }

    // Botón Anterior
    const btnAnterior = document.createElement('li');
    btnAnterior.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
    const linkAnterior = document.createElement('a');
    linkAnterior.className = 'page-link';
    linkAnterior.href = '#';
    linkAnterior.textContent = 'Anterior';
    linkAnterior.addEventListener('click', function(e) {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            cargarAuditoria();
        }
    });
    btnAnterior.appendChild(linkAnterior);
    paginacion.appendChild(btnAnterior);

    // Determinar qué números de página mostrar
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, startPage + 4);
    
    // Ajustar si estamos cerca del final
    if (endPage - startPage < 4) {
        startPage = Math.max(1, endPage - 4);
    }

    // Primera página y elipsis si es necesario
    if (startPage > 1) {
        const btnPrimera = document.createElement('li');
        btnPrimera.className = 'page-item';
        const linkPrimera = document.createElement('a');
        linkPrimera.className = 'page-link';
        linkPrimera.href = '#';
        linkPrimera.textContent = '1';
        linkPrimera.addEventListener('click', function(e) {
            e.preventDefault();
            currentPage = 1;
            cargarAuditoria();
        });
        btnPrimera.appendChild(linkPrimera);
        paginacion.appendChild(btnPrimera);

        if (startPage > 2) {
            const elipsis = document.createElement('li');
            elipsis.className = 'page-item disabled';
            const linkElipsis = document.createElement('a');
            linkElipsis.className = 'page-link';
            linkElipsis.href = '#';
            linkElipsis.textContent = '...';
            elipsis.appendChild(linkElipsis);
            paginacion.appendChild(elipsis);
        }
    }

    // Números de página
    for (let i = startPage; i <= endPage; i++) {
        const btnPagina = document.createElement('li');
        btnPagina.className = `page-item ${i === currentPage ? 'active' : ''}`;
        const linkPagina = document.createElement('a');
        linkPagina.className = 'page-link';
        linkPagina.href = '#';
        linkPagina.textContent = i;
        linkPagina.addEventListener('click', function(e) {
            e.preventDefault();
            currentPage = i;
            cargarAuditoria();
        });
        btnPagina.appendChild(linkPagina);
        paginacion.appendChild(btnPagina);
    }

    // Elipsis y última página si es necesario
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            const elipsis = document.createElement('li');
            elipsis.className = 'page-item disabled';
            const linkElipsis = document.createElement('a');
            linkElipsis.className = 'page-link';
            linkElipsis.href = '#';
            linkElipsis.textContent = '...';
            elipsis.appendChild(linkElipsis);
            paginacion.appendChild(elipsis);
        }

        const btnUltima = document.createElement('li');
        btnUltima.className = 'page-item';
        const linkUltima = document.createElement('a');
        linkUltima.className = 'page-link';
        linkUltima.href = '#';
        linkUltima.textContent = totalPages;
        linkUltima.addEventListener('click', function(e) {
            e.preventDefault();
            currentPage = totalPages;
            cargarAuditoria();
        });
        btnUltima.appendChild(linkUltima);
        paginacion.appendChild(btnUltima);
    }

    // Botón Siguiente
    const btnSiguiente = document.createElement('li');
    btnSiguiente.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
    const linkSiguiente = document.createElement('a');
    linkSiguiente.className = 'page-link';
    linkSiguiente.href = '#';
    linkSiguiente.textContent = 'Siguiente';
    linkSiguiente.addEventListener('click', function(e) {
        e.preventDefault();
        if (currentPage < totalPages) {
            currentPage++;
            cargarAuditoria();
        }
    });
    btnSiguiente.appendChild(linkSiguiente);
    paginacion.appendChild(btnSiguiente);
}

/**
 * Aplica los filtros seleccionados
 */
function aplicarFiltros() {
    // Resetear a la primera página al aplicar filtros
    currentPage = 1;
    cargarAuditoria();
}

/**
 * Limpia todos los filtros
 */
function limpiarFiltros() {
    // Resetear fechas a los últimos 30 días
    const hoy = new Date();
    const hace30Dias = new Date();
    hace30Dias.setDate(hoy.getDate() - 30);

    document.getElementById('fechaDesde').value = hace30Dias.toISOString().split('T')[0];
    document.getElementById('fechaHasta').value = hoy.toISOString().split('T')[0];
    
    // Limpiar otros filtros
    document.getElementById('filtroTabla').value = '';
    document.getElementById('filtroOperacion').value = '';
    document.getElementById('filtroUsuario').value = '';
    document.getElementById('filtroExpediente').value = '';
    document.getElementById('filtroDNI').value = '';
    
    // Aplicar filtros limpios
    aplicarFiltros();
}

/**
 * Exporta los registros de auditoría a CSV
 */
function exportarCSV() {
    // Obtener valores de filtros
    const fechaDesde = document.getElementById('fechaDesde').value;
    const fechaHasta = document.getElementById('fechaHasta').value;
    const tabla = document.getElementById('filtroTabla').value;
    const operacion = document.getElementById('filtroOperacion').value;
    const usuario = document.getElementById('filtroUsuario').value;
    const expediente = document.getElementById('filtroExpediente').value;
    const dni = document.getElementById('filtroDNI').value;

    // Mostrar indicador de carga
    Swal.fire({
        title: 'Exportando...',
        text: 'Generando archivo CSV',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Realizar petición AJAX
    fetch(`phpserv/exportar_auditoria_csv.php?date_from=${fechaDesde}&date_to=${fechaHasta}&tabla=${tabla}&operacion=${operacion}&usuario=${usuario}&expediente=${expediente}&dni=${dni}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al exportar a CSV');
            }
            return response.blob();
        })
        .then(blob => {
            // Crear URL para descargar el archivo
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'auditoria.csv';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);

            // Mostrar mensaje de éxito
            Swal.fire({
                title: 'Éxito',
                text: 'Archivo CSV generado correctamente',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        })
        .catch(error => {
            mostrarError('Error', 'No se pudo exportar a CSV: ' + error.message);
        });
}

/**
 * Exporta los registros de auditoría a PDF
 */
function exportarPDF() {
    // Obtener valores de filtros
    const fechaDesde = document.getElementById('fechaDesde').value;
    const fechaHasta = document.getElementById('fechaHasta').value;
    const tabla = document.getElementById('filtroTabla').value;
    const operacion = document.getElementById('filtroOperacion').value;
    const usuario = document.getElementById('filtroUsuario').value;
    const expediente = document.getElementById('filtroExpediente').value;
    const dni = document.getElementById('filtroDNI').value;

    // Mostrar indicador de carga
    Swal.fire({
        title: 'Exportando...',
        text: 'Generando archivo PDF',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Realizar petición AJAX
    fetch(`phpserv/exportar_auditoria_pdf.php?date_from=${fechaDesde}&date_to=${fechaHasta}&tabla=${tabla}&operacion=${operacion}&usuario=${usuario}&expediente=${expediente}&dni=${dni}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al exportar a PDF');
            }
            return response.blob();
        })
        .then(blob => {
            // Crear URL para descargar el archivo
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'auditoria.pdf';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);

            // Mostrar mensaje de éxito
            Swal.fire({
                title: 'Éxito',
                text: 'Archivo PDF generado correctamente',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        })
        .catch(error => {
            mostrarError('Error', 'No se pudo exportar a PDF: ' + error.message);
        });
}

/**
 * Muestra un mensaje de error utilizando SweetAlert2
 */
function mostrarError(titulo, mensaje) {
    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: 'error',
        confirmButtonText: 'Aceptar'
    });
}

/**
 * Muestra los detalles de un registro de auditoría en el div detallesRegistro
 */
function verDetalles(registro) {
    // Crear contenido HTML para mostrar todos los detalles del registro
    let contenidoHTML = `
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>ID:</th>
                    <td>${registro.id}</td>
                </tr>
estadodenuncia.php                <tr>
                    <th>Fecha:</th>
                    <td>${registro.fecha}</td>
                </tr>
                <tr>
                    <th>Hora:</th>
                    <td>${registro.hora}</td>
                </tr>
                <tr>
                    <th>Usuario:</th>
                    <td>${registro.usuario}</td>
                </tr>
                <tr>
                    <th>Tabla:</th>
                    <td>${registro.tabla_afectada}</td>
                </tr>
                <tr>
                    <th>Operación:</th>
                    <td>${registro.operacion}</td>
                </tr>
                <tr>
                    <th>Expediente:</th>
                    <td>${registro.num_expediente || '-'}</td>
                </tr>
                <tr>
                    <th>DNI:</th>
                    <td>${registro.dni || '-'}</td>
                </tr>
                <tr>
                    <th>Detalles:</th>
                    <td>${registro.detalles || '-'}</td>
                </tr>
            </table>
        </div>
    `;
    
    // Mostrar los detalles en el div
    const detallesDiv = document.getElementById('detallesRegistro');
    const contenidoDetalles = document.getElementById('contenidoDetalles');
    
    // Insertar el contenido HTML en el div
    contenidoDetalles.innerHTML = contenidoHTML;
    
    // Mostrar el div de detalles
    detallesDiv.style.display = 'block';
    
    // Hacer scroll hasta el div de detalles
    detallesDiv.scrollIntoView({ behavior: 'smooth' });
}

/**
 * Cierra el div de detalles
 */
function cerrarDetalles() {
    const detallesDiv = document.getElementById('detallesRegistro');
    detallesDiv.style.display = 'none';
}

/**
 * Abre un modal para editar un registro de auditoría
 */
function editarRegistro(registro) {
    // Crear formulario HTML para editar el registro
    let formHTML = `
        <form id="formEditarAuditoria">
            <div class="mb-3">
                <label for="editUsuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" id="editUsuario" value="${registro.usuario}">
            </div>
            <div class="mb-3">
                <label for="editTabla" class="form-label">Tabla:</label>
                <input type="text" class="form-control" id="editTabla" value="${registro.tabla_afectada}">
            </div>
            <div class="mb-3">
                <label for="editOperacion" class="form-label">Operación:</label>
                <select class="form-control" id="editOperacion">
                    <option value="INSERT" ${registro.operacion === 'INSERT' ? 'selected' : ''}>INSERT</option>
                    <option value="UPDATE" ${registro.operacion === 'UPDATE' ? 'selected' : ''}>UPDATE</option>
                    <option value="DELETE" ${registro.operacion === 'DELETE' ? 'selected' : ''}>DELETE</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="editExpediente" class="form-label">Expediente:</label>
                <input type="text" class="form-control" id="editExpediente" value="${registro.num_expediente || ''}">
            </div>
            <div class="mb-3">
                <label for="editDNI" class="form-label">DNI:</label>
                <input type="text" class="form-control" id="editDNI" value="${registro.dni || ''}">
            </div>
            <div class="mb-3">
                <label for="editDetalles" class="form-label">Detalles:</label>
                <textarea class="form-control" id="editDetalles" rows="3">${registro.detalles || ''}</textarea>
            </div>
        </form>
    `;
    
    Swal.fire({
        title: 'Editar Registro',
        html: formHTML,
        width: '600px',
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            // Recoger los datos del formulario
            const datosActualizados = {
                id: registro.id,
                usuario: document.getElementById('editUsuario').value,
                tabla_afectada: document.getElementById('editTabla').value,
                operacion: document.getElementById('editOperacion').value,
                num_expediente: document.getElementById('editExpediente').value,
                dni: document.getElementById('editDNI').value,
                detalles: document.getElementById('editDetalles').value
            };
            
            // Enviar los datos actualizados al servidor
            return actualizarRegistroAuditoria(datosActualizados);
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire('¡Guardado!', 'El registro ha sido actualizado.', 'success');
            cargarAuditoria(); // Recargar la tabla
        }
    });
}

/**
 * Envía los datos actualizados al servidor
 */
function actualizarRegistroAuditoria(datos) {
    return fetch('phpserv/actualizar_auditoria.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al actualizar el registro');
        }
        return response.json();
    })
    .catch(error => {
        mostrarError('Error', error.message);
        return false;
    });
}

/**
 * Elimina un registro de auditoría
 */
function eliminarRegistro(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar solicitud para eliminar el registro
            fetch(`phpserv/eliminar_auditoria.php?id=${id}`, {
                method: 'DELETE'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al eliminar el registro');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('¡Eliminado!', 'El registro ha sido eliminado.', 'success');
                    cargarAuditoria(); // Recargar la tabla
                } else {
                    throw new Error(data.message || 'Error al eliminar');
                }
            })
            .catch(error => {
                mostrarError('Error', error.message);
            });
        }
    });
}
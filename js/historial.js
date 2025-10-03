/**
 * historial.js - Funcionalidades para la página de historial de accesos
 * Sistema de control de intentos de login y gestión de usuarios
 */

// Variables globales
let currentPage = 1;
let totalPages = 1;
let itemsPerPage = 15;
let filters = {
    dateFrom: '',
    dateTo: '',
    status: '',
    user: ''
};

// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    // Cargar datos iniciales
    cargarEstadisticas();
    cargarHistorial();
    
    // Configurar eventos
    document.getElementById('btn-refresh').addEventListener('click', cargarHistorial);
    document.getElementById('btn-export-csv').addEventListener('click', exportarCSV);
    document.getElementById('btn-export-pdf').addEventListener('click', exportarPDF);
    document.getElementById('btn-apply-filters').addEventListener('click', aplicarFiltros);
    document.getElementById('btn-clear-filters').addEventListener('click', limpiarFiltros);
    
    // Establecer fecha actual en el filtro "hasta"
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('filter-date-to').value = today;
    
    // Establecer fecha hace 30 días en el filtro "desde"
    const thirtyDaysAgo = new Date();
    thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
    document.getElementById('filter-date-from').value = thirtyDaysAgo.toISOString().split('T')[0];
});

/**
 * Carga las estadísticas generales del sistema
 */
function cargarEstadisticas() {
    // Realizar petición AJAX para obtener estadísticas
    $.ajax({
        url: 'phpserv/get_estadisticas_historial.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Actualizar contadores en la interfaz
                document.getElementById('success-count').textContent = response.data.accesos_exitosos;
                document.getElementById('failed-count').textContent = response.data.accesos_fallidos;
                document.getElementById('block-count').textContent = response.data.bloqueos;
            } else {
                mostrarError('Error al cargar estadísticas', response.message);
            }
        },
        error: function() {
            mostrarError('Error de conexión', 'No se pudo conectar con el servidor para obtener estadísticas.');
        }
    });
}

/**
 * Carga el historial de accesos al sistema
 */
function cargarHistorial() {
    // Mostrar indicador de carga
    const tableBody = document.getElementById('history-table-body');
    tableBody.innerHTML = '<tr><td colspan="6" class="text-center"><i class="fas fa-spinner fa-spin me-2"></i>Cargando historial...</td></tr>';
    
    // Preparar datos para la petición
    const data = {
        page: currentPage,
        items_per_page: itemsPerPage
    };
    
    // Añadir filtros si están definidos
    if (filters.dateFrom) data.date_from = filters.dateFrom;
    if (filters.dateTo) data.date_to = filters.dateTo;
    if (filters.status !== '') data.status = filters.status;
    if (filters.user) data.user = filters.user;
    
    // Realizar petición AJAX para obtener historial
    $.ajax({
        url: 'phpserv/get_historial.php',
        type: 'GET',
        data: data,
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                mostrarHistorial(response.data.registros);
                actualizarPaginacion(response.data.total_pages);
            } else {
                mostrarError('Error al cargar historial', response.message);
                tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-danger">Error al cargar historial</td></tr>';
            }
        },
        error: function() {
            mostrarError('Error de conexión', 'No se pudo conectar con el servidor para obtener el historial.');
            tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-danger">Error de conexión al servidor</td></tr>';
        }
    });
}

/**
 * Muestra el historial de accesos en la tabla
 * @param {Array} registros - Array de objetos con los registros de acceso
 */
function mostrarHistorial(registros) {
    const tableBody = document.getElementById('history-table-body');
    tableBody.innerHTML = '';
    
    if (registros.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center">No se encontraron registros</td></tr>';
        return;
    }
    
    registros.forEach(function(registro) {
        const tr = document.createElement('tr');
        
        // Determinar clase CSS según estado
        if (registro.exito == 0) {
            tr.classList.add('table-danger');
        } else {
            tr.classList.add('table-success');
        }
        
        // Formatear fecha
        let fecha = new Date(registro.fecha).toLocaleString();
        
        // Crear contenido de la fila
        tr.innerHTML = `
            <td>${registro.id}</td>
            <td>${registro.usuario || 'N/A'}</td>
            <td>${fecha}</td>
            <td>${registro.ip}</td>
            <td class="${registro.exito == 1 ? 'status-success' : 'status-failed'}">
                ${registro.exito == 1 ? 'Exitoso' : 'Fallido'}
            </td>
            <td>${registro.detalles || '-'}</td>
        `;
        
        tableBody.appendChild(tr);
    });
}

/**
 * Actualiza la paginación según el total de páginas
 * @param {number} totalPages - Número total de páginas
 */
function actualizarPaginacion(totalPages) {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';
    
    // Guardar el total de páginas
    window.totalPages = totalPages;
    
    // Si solo hay una página, no mostrar paginación
    if (totalPages <= 1) {
        return;
    }
    
    // Botón Anterior
    const prevLi = document.createElement('li');
    prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<a class="page-link" href="#" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a>`;
    prevLi.addEventListener('click', function(e) {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            cargarHistorial();
        }
    });
    pagination.appendChild(prevLi);
    
    // Determinar rango de páginas a mostrar
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, startPage + 4);
    
    // Ajustar si estamos cerca del final
    if (endPage - startPage < 4) {
        startPage = Math.max(1, endPage - 4);
    }
    
    // Primera página si no está en el rango
    if (startPage > 1) {
        const firstLi = document.createElement('li');
        firstLi.className = 'page-item';
        firstLi.innerHTML = `<a class="page-link" href="#">1</a>`;
        firstLi.addEventListener('click', function(e) {
            e.preventDefault();
            currentPage = 1;
            cargarHistorial();
        });
        pagination.appendChild(firstLi);
        
        // Puntos suspensivos si hay salto
        if (startPage > 2) {
            const ellipsisLi = document.createElement('li');
            ellipsisLi.className = 'page-item disabled';
            ellipsisLi.innerHTML = `<a class="page-link" href="#">...</a>`;
            pagination.appendChild(ellipsisLi);
        }
    }
    
    // Páginas numeradas
    for (let i = startPage; i <= endPage; i++) {
        const pageLi = document.createElement('li');
        pageLi.className = `page-item ${i === currentPage ? 'active' : ''}`;
        pageLi.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        pageLi.addEventListener('click', function(e) {
            e.preventDefault();
            currentPage = i;
            cargarHistorial();
        });
        pagination.appendChild(pageLi);
    }
    
    // Puntos suspensivos si hay salto al final
    if (endPage < totalPages - 1) {
        const ellipsisLi = document.createElement('li');
        ellipsisLi.className = 'page-item disabled';
        ellipsisLi.innerHTML = `<a class="page-link" href="#">...</a>`;
        pagination.appendChild(ellipsisLi);
    }
    
    // Última página si no está en el rango
    if (endPage < totalPages) {
        const lastLi = document.createElement('li');
        lastLi.className = 'page-item';
        lastLi.innerHTML = `<a class="page-link" href="#">${totalPages}</a>`;
        lastLi.addEventListener('click', function(e) {
            e.preventDefault();
            currentPage = totalPages;
            cargarHistorial();
        });
        pagination.appendChild(lastLi);
    }
    
    // Botón Siguiente
    const nextLi = document.createElement('li');
    nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
    nextLi.innerHTML = `<a class="page-link" href="#" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a>`;
    nextLi.addEventListener('click', function(e) {
        e.preventDefault();
        if (currentPage < totalPages) {
            currentPage++;
            cargarHistorial();
        }
    });
    pagination.appendChild(nextLi);
}

/**
 * Aplica los filtros seleccionados
 */
function aplicarFiltros() {
    // Obtener valores de los filtros
    filters.dateFrom = document.getElementById('filter-date-from').value;
    filters.dateTo = document.getElementById('filter-date-to').value;
    filters.status = document.getElementById('filter-status').value;
    filters.user = document.getElementById('filter-user').value.trim();
    
    // Reiniciar a la primera página
    currentPage = 1;
    
    // Cargar historial con filtros
    cargarHistorial();
}

/**
 * Limpia los filtros aplicados
 */
function limpiarFiltros() {
    // Establecer fecha actual en el filtro "hasta"
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('filter-date-to').value = today;
    
    // Establecer fecha hace 30 días en el filtro "desde"
    const thirtyDaysAgo = new Date();
    thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
    document.getElementById('filter-date-from').value = thirtyDaysAgo.toISOString().split('T')[0];
    
    // Limpiar otros filtros
    document.getElementById('filter-status').value = '';
    document.getElementById('filter-user').value = '';
    
    // Reiniciar objeto de filtros
    filters = {
        dateFrom: thirtyDaysAgo.toISOString().split('T')[0],
        dateTo: today,
        status: '',
        user: ''
    };
    
    // Reiniciar a la primera página
    currentPage = 1;
    
    // Cargar historial sin filtros
    cargarHistorial();
}

/**
 * Exporta el historial a CSV
 */
function exportarCSV() {
    // Preparar datos para la petición
    const data = {};
    
    // Añadir filtros si están definidos
    if (filters.dateFrom) data.date_from = filters.dateFrom;
    if (filters.dateTo) data.date_to = filters.dateTo;
    if (filters.status !== '') data.status = filters.status;
    if (filters.user) data.user = filters.user;
    
    $.ajax({
        url: 'phpserv/exportar_historial_csv.php',
        type: 'GET',
        data: data,
        success: function(response) {
            // Crear un blob con los datos CSV
            const blob = new Blob([response], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            
            // Crear un enlace temporal y hacer clic en él para descargar
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'historial_accesos_' + new Date().toISOString().split('T')[0] + '.csv';
            document.body.appendChild(a);
            a.click();
            
            // Limpiar
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            
            Swal.fire({
                title: 'Exportación exitosa',
                text: 'El archivo CSV ha sido generado correctamente.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        },
        error: function() {
            mostrarError('Error de exportación', 'No se pudo generar el archivo CSV.');
        }
    });
}

/**
 * Exporta el historial a PDF
 */
function exportarPDF() {
    Swal.fire({
        title: 'Generando PDF',
        text: 'Por favor espere mientras se genera el documento...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Preparar datos para la petición
    const data = {};
    
    // Añadir filtros si están definidos
    if (filters.dateFrom) data.date_from = filters.dateFrom;
    if (filters.dateTo) data.date_to = filters.dateTo;
    if (filters.status !== '') data.status = filters.status;
    if (filters.user) data.user = filters.user;
    
    $.ajax({
        url: 'phpserv/exportar_historial_pdf.php',
        type: 'GET',
        data: data,
        xhrFields: {
            responseType: 'blob'
        },
        success: function(blob) {
            Swal.close();
            
            // Crear URL para el blob
            const url = window.URL.createObjectURL(blob);
            
            // Crear un enlace temporal y hacer clic en él para descargar
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'historial_accesos_' + new Date().toISOString().split('T')[0] + '.pdf';
            document.body.appendChild(a);
            a.click();
            
            // Limpiar
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            
            Swal.fire({
                title: 'Exportación exitosa',
                text: 'El archivo PDF ha sido generado correctamente.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        },
        error: function() {
            Swal.close();
            mostrarError('Error de exportación', 'No se pudo generar el archivo PDF.');
        }
    });
}

/**
 * Muestra un mensaje de error utilizando SweetAlert2
 * @param {string} titulo - Título del mensaje de error
 * @param {string} mensaje - Descripción del error
 */
function mostrarError(titulo, mensaje) {
    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: 'error',
        confirmButtonColor: '#dc3545'
    });
}
/**
 * admin.js - Funcionalidades para el panel de administración
 * Sistema de control de intentos de login y gestión de usuarios
 */

// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    // Cargar datos iniciales
    cargarEstadisticas();
    cargarUsuarios();
    
    // Configurar eventos
    document.getElementById('btn-refresh').addEventListener('click', function() {
        cargarUsuarios();
        cargarEstadisticas();
    });
    document.getElementById('btn-export-csv').addEventListener('click', exportarCSV);
    document.getElementById('btn-export-pdf').addEventListener('click', exportarPDF);
    document.getElementById('btn-search').addEventListener('click', buscarUsuarios);
    document.getElementById('search-user').addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            buscarUsuarios();
        }
    });
    
    // Verificar periódicamente las estadísticas
    setInterval(cargarEstadisticas, 30000); // Actualizar cada 30 segundos
});

/**
 * Carga las estadísticas generales del sistema
 */
function cargarEstadisticas() {
    // Realizar petición AJAX para obtener estadísticas
    $.ajax({
        url: 'phpserv/get_estadisticas_usuarios.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Actualizar contadores en la interfaz
                console.log('Datos recibidos:', response.data);
                const bloqueadosElement = document.getElementById('usuarios-bloqueados');
                const activosElement = document.getElementById('usuarios-activos');
                
                if (bloqueadosElement && activosElement) {
                    // Si es la primera carga, simplemente establecer los valores
                    if (bloqueadosElement.textContent === '0' && activosElement.textContent === '0') {
                        bloqueadosElement.textContent = response.data.usuarios_bloqueados || '0';
                        activosElement.textContent = response.data.usuarios_activos || '0';
                    } else {
                        // Si ya hay valores, animar el cambio
                        animateValue(bloqueadosElement, parseInt(bloqueadosElement.textContent), parseInt(response.data.usuarios_bloqueados || 0));
                        animateValue(activosElement, parseInt(activosElement.textContent), parseInt(response.data.usuarios_activos || 0));
                    }
                }
            } else {
                mostrarError('Error al cargar estadísticas', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error AJAX:', status, error);
            mostrarError('Error de conexión', 'No se pudo conectar con el servidor para obtener estadísticas.');
        }
    });
}

/**
 * Carga la lista de usuarios del sistema
 */
function cargarUsuarios() {
    // Mostrar indicador de carga
    const tableBody = document.getElementById('users-table-body');
    tableBody.innerHTML = '<tr><td colspan="9" class="text-center"><i class="fas fa-spinner fa-spin me-2"></i>Cargando usuarios...</td></tr>';
    
    // Realizar petición AJAX para obtener usuarios
    $.ajax({
        url: 'phpserv/get_usuarios.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                mostrarUsuarios(response.data);
            } else {
                mostrarError('Error al cargar usuarios', response.message);
                tableBody.innerHTML = '<tr><td colspan="9" class="text-center text-danger">Error al cargar usuarios</td></tr>';
            }
        },
        error: function() {
            mostrarError('Error de conexión', 'No se pudo conectar con el servidor para obtener la lista de usuarios.');
            tableBody.innerHTML = '<tr><td colspan="9" class="text-center text-danger">Error de conexión al servidor</td></tr>';
        }
    });
}

/**
 * Muestra la lista de usuarios en la tabla
 * @param {Array} usuarios - Array de objetos usuario
 */
function mostrarUsuarios(usuarios) {
    const tableBody = document.getElementById('users-table-body');
    tableBody.innerHTML = '';
    
    if (usuarios.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="9" class="text-center">No se encontraron usuarios</td></tr>';
        return;
    }
    
    usuarios.forEach(function(usuario) {
        const tr = document.createElement('tr');
        
        // Determinar clase CSS según estado
        if (usuario.bloqueado == 1) {
            tr.classList.add('table-danger');
        }
        
        // Formatear fecha de bloqueo
        let fechaBloqueo = usuario.fecha_bloqueo ? new Date(usuario.fecha_bloqueo).toLocaleString() : '-';
        
        // Crear contenido de la fila
        tr.innerHTML = `
            <td>${usuario.idusuarios}</td>
            <td>${usuario.usuario}</td>
            <td>${usuario.Nombre}</td>
            <td>${usuario.Apellido}</td>
            <td>${usuario.rol || 'usuario'}</td>
            <td class="${usuario.bloqueado == 1 ? 'status-blocked' : 'status-active'}">
                ${usuario.bloqueado == 1 ? 'Bloqueado' : 'Activo'}
            </td>
            <td>${usuario.intentos_fallidos || 0}</td>
            <td>${fechaBloqueo}</td>
            <td>
                ${usuario.bloqueado == 1 ? 
                    `<button class="btn btn-sm btn-unlock" data-user-id="${usuario.idusuarios}">
                        <i class="fas fa-unlock me-1"></i>Desbloquear
                    </button>` : 
                    `<button class="btn btn-sm btn-secondary" disabled>
                        <i class="fas fa-check me-1"></i>Activo
                    </button>`
                }
            </td>
        `;
        
        tableBody.appendChild(tr);
    });
    
    // Añadir eventos a los botones de desbloqueo
    document.querySelectorAll('.btn-unlock').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            desbloquearUsuario(userId);
        });
    });
}

/**
 * Desbloquea un usuario
 * @param {number} userId - ID del usuario a desbloquear
 */
function desbloquearUsuario(userId) {
    Swal.fire({
        title: '¿Desbloquear usuario?',
        text: '¿Está seguro que desea desbloquear este usuario?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Sí, desbloquear',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Realizar petición AJAX para desbloquear usuario
            $.ajax({
                url: 'phpserv/desbloquear_usuario.php',
                type: 'POST',
                data: { id_usuario: userId },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: '¡Desbloqueado!',
                            text: 'El usuario ha sido desbloqueado exitosamente.',
                            icon: 'success',
                            didClose: () => {
                                // Recargar datos después de cerrar el mensaje
                                cargarUsuarios();
                                actualizarEstadisticas();
                            }
                        });
                    } else {
                        mostrarError('Error al desbloquear', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al desbloquear:', status, error);
                    mostrarError('Error de conexión', 'No se pudo conectar con el servidor para desbloquear al usuario.');
                }
            });
        }
    });
}

/**
 * Actualiza las estadísticas y asegura que los divs se actualicen correctamente
 */
function actualizarEstadisticas() {
    // Realizar petición AJAX para obtener estadísticas actualizadas
    $.ajax({
        url: 'phpserv/get_estadisticas_usuarios.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                console.log('Estadísticas actualizadas:', response.data);
                // Actualizar contadores en la interfaz con animación
                const bloqueadosElement = document.getElementById('usuarios-bloqueados');
                const activosElement = document.getElementById('usuarios-activos');
                
                if (bloqueadosElement && activosElement) {
                    // Aplicar valores con animación
                    animateValue(bloqueadosElement, parseInt(bloqueadosElement.textContent), parseInt(response.data.usuarios_bloqueados || 0));
                    animateValue(activosElement, parseInt(activosElement.textContent), parseInt(response.data.usuarios_activos || 0));
                }
            }
        }
    });
}

/**
 * Anima el cambio de valor en un elemento
 * @param {HTMLElement} element - Elemento a animar
 * @param {number} start - Valor inicial
 * @param {number} end - Valor final
 */
function animateValue(element, start, end) {
    if (start === end) return;
    const duration = 500;
    const range = end - start;
    const startTime = new Date().getTime();
    
    const timer = setInterval(function() {
        const time = new Date().getTime() - startTime;
        const value = Math.floor(start + (range * (time / duration)));
        
        if (time >= duration) {
            clearInterval(timer);
            element.textContent = end;
        } else {
            element.textContent = value;
        }
    }, 16);
}

/**
 * Busca usuarios según el término ingresado
 */
function buscarUsuarios() {
    const searchTerm = document.getElementById('search-user').value.trim();
    
    if (searchTerm === '') {
        cargarUsuarios();
        return;
    }
    
    // Mostrar indicador de búsqueda
    const tableBody = document.getElementById('users-table-body');
    tableBody.innerHTML = '<tr><td colspan="9" class="text-center"><i class="fas fa-search me-2"></i>Buscando "' + searchTerm + '"...</td></tr>';
    
    // Realizar petición AJAX para buscar usuarios
    $.ajax({
        url: 'phpserv/buscar_usuarios.php',
        type: 'GET',
        data: { termino: searchTerm },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                mostrarUsuarios(response.data);
            } else {
                mostrarError('Error en la búsqueda', response.message);
                tableBody.innerHTML = '<tr><td colspan="9" class="text-center text-danger">Error en la búsqueda</td></tr>';
            }
        },
        error: function() {
            mostrarError('Error de conexión', 'No se pudo conectar con el servidor para realizar la búsqueda.');
            tableBody.innerHTML = '<tr><td colspan="9" class="text-center text-danger">Error de conexión al servidor</td></tr>';
        }
    });
}

/**
 * Exporta la lista de usuarios a CSV
 */
function exportarCSV() {
    $.ajax({
        url: 'phpserv/exportar_usuarios_csv.php',
        type: 'GET',
        success: function(response) {
            // Crear un blob con los datos CSV
            const blob = new Blob([response], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            
            // Crear un enlace temporal y hacer clic en él para descargar
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'usuarios_' + new Date().toISOString().split('T')[0] + '.csv';
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
 * Exporta la lista de usuarios a PDF
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
    
    $.ajax({
        url: 'phpserv/exportar_usuarios_pdf.php',
        type: 'GET',
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
            a.download = 'usuarios_' + new Date().toISOString().split('T')[0] + '.pdf';
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
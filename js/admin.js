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
        url: '/phpserv/get_estadisticas_usuarios.php',
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
        url: '/phpserv/get_usuarios.php',
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
                <div class="btn-group" role="group">
                    ${usuario.bloqueado == 1 ? 
                        `<button class="btn btn-sm btn-unlock btn-outline-success" title="Desbloquear" data-user-id="${usuario.idusuarios}">
                            <i class="fas fa-unlock"></i>
                        </button>` : 
                        `<button class="btn btn-sm btn-outline-secondary" title="Activo" disabled>
                            <i class="fas fa-check"></i>
                        </button>`
                    }
                    <button class="btn btn-sm btn-edit-user btn-outline-primary" title="Modificar" data-user-id="${usuario.idusuarios}" data-user-usuario="${usuario.usuario}" data-user-nombre="${usuario.Nombre}" data-user-apellido="${usuario.Apellido}" data-user-rol="${usuario.rol || 'usuario'}">
                        <i class="fas fa-pen"></i>
                    </button>
                    <button class="btn btn-sm btn-delete-user btn-outline-danger" title="Eliminar" data-user-id="${usuario.idusuarios}" data-user-usuario="${usuario.usuario}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
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

    // Añadir eventos a los botones de edición
    document.querySelectorAll('.btn-edit-user').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const usuario = this.getAttribute('data-user-usuario');
            const nombre = this.getAttribute('data-user-nombre');
            const apellido = this.getAttribute('data-user-apellido');
            const rol = this.getAttribute('data-user-rol');
            editarUsuario({ id: userId, usuario, nombre, apellido, rol });
        });
    });

    // Añadir eventos a los botones de eliminación
    document.querySelectorAll('.btn-delete-user').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const usuario = this.getAttribute('data-user-usuario');
            eliminarUsuario(userId, usuario);
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
                url: '/phpserv/desbloquear_usuario.php',
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

/**
 * Edita datos básicos de un usuario (Nombre, Apellido, Rol, Correo opcional)
 */
function editarUsuario(info) {
    Swal.fire({
        title: 'Modificar usuario',
        html:
            '<div class="mb-2 text-start"><label class="form-label">Usuario</label><input id="swUsuario" class="form-control" value="'+ (info.usuario || '') +'" disabled></div>'+
            '<div class="mb-2 text-start"><label class="form-label">Nombre</label><input id="swNombre" class="form-control" value="'+ (info.nombre || '') +'"></div>'+
            '<div class="mb-2 text-start"><label class="form-label">Apellido</label><input id="swApellido" class="form-control" value="'+ (info.apellido || '') +'"></div>'+
            '<div class="mb-2 text-start"><label class="form-label">Rol</label><select id="swRol" class="form-select">'+
                '<option value="usuario" '+ (String(info.rol).toLowerCase()==='usuario'?'selected':'') +'>Usuario</option>'+
                '<option value="administrador" '+ (String(info.rol).toLowerCase()==='administrador'?'selected':'') +'>Administrador</option>'+
            '</select></div>'+
            '<div class="mb-2 text-start"><label class="form-label">Correo</label><input id="swCorreo" class="form-control" placeholder="Opcional"></div>'+
            '<div class="mb-2 text-start"><label class="form-label">Nueva contraseña</label><input id="swPass" type="password" class="form-control" placeholder="Opcional"></div>',
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            return {
                id: parseInt(info.id,10),
                nombre: document.getElementById('swNombre').value.trim(),
                apellido: document.getElementById('swApellido').value.trim(),
                rol: document.getElementById('swRol').value,
                correo: document.getElementById('swCorreo').value.trim(),
                contrasena: document.getElementById('swPass').value
            };
        }
    }).then(function(result){
        if (result.isConfirmed) {
            const datos = result.value || {};
            const body = new URLSearchParams(datos).toString();
            fetch('/phpserv/actualizar_usuario.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                credentials: 'same-origin',
                body
            }).then(function(res){
                var ok = res.ok;
                var status = res.status;
                return res.text().then(function(t){
                    var obj = null;
                    try { obj = JSON.parse(t); } catch(_){}
                    if (ok) {
                        if (obj && obj.status) return obj;
                        var s = String(t || '').trim().toLowerCase();
                        if (s === 'success' || s === 'si' || s === 'ok') return { status: 'success' };
                        return { status: 'success' };
                    } 
                });
            }).then(function(response){
                if (response && response.status === 'success') {
                    Swal.fire({ toast:true, position:'top-end', icon:'success', title:'Usuario modificado', showConfirmButton:false, timer:2500 });
                    cargarUsuarios(); actualizarEstadisticas();
                }
            });
        }
    });
}

/**
 * Elimina un usuario
 */
function eliminarUsuario(id, usuario) {
    Swal.fire({
        title: 'Eliminar usuario',
        text: '¿Desea eliminar el usuario "' + (usuario || id) + '"? Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(function(result){
        if (result.isConfirmed) {
            const body = new URLSearchParams({ id_usuario: id }).toString();
            fetch('/phpserv/eliminar_usuario.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                credentials: 'same-origin',
                body
            }).then(function(res){
                var ok = res.ok;
                var status = res.status;
                return res.text().then(function(t){
                    var obj = null;
                    try { obj = JSON.parse(t); } catch(_){}
                    if (ok) {
                        if (obj && obj.status) return obj;
                        var s = String(t || '').trim().toLowerCase();
                        if (s === 'success' || s === 'si' || s === 'ok') return { status: 'success' };
                        return { status: 'success' };
                    } else {
                        if (obj) return obj;
                        return { status: 'error', message: (status===403 ? 'No puede eliminar su propio usuario o no tiene permisos' : 'Error '+status) };
                    }
                });
            }).then(function(response){
                if (response && response.status === 'success') {
                    Swal.fire({ toast:true, position:'top-end', icon:'success', title:'Usuario eliminado', showConfirmButton:false, timer:2500 });
                    cargarUsuarios(); actualizarEstadisticas();
                } else {
                    Swal.fire({ icon:'error', title:'No se pudo eliminar', text: (response && response.message) || 'Ocurrió un problema al eliminar el usuario', confirmButtonText:'Cerrar' });
                }
            }).catch(function(){
                Swal.fire({ icon:'error', title:'Operación no realizada', html:'No fue posible eliminar el usuario.<br><small>Compruebe la conexión y permisos de administrador</small>', confirmButtonText:'Entendido' });
            });
        }
    });
}
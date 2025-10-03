<?php
/**
 * exportar_usuarios_csv.php
 * Exporta la lista de usuarios a formato CSV
 */

// Iniciar sesión
session_start();

// Verificar permisos de administrador de forma consistente
$rolSesion = isset($_SESSION['rol']) ? strtolower(trim($_SESSION['rol'])) : null;
$tipoSesion = isset($_SESSION['tipo']) ? strtolower(trim($_SESSION['tipo'])) : null;
if ($rolSesion !== 'administrador' && $tipoSesion !== 'admin') {
    header('Content-Type: text/plain');
    echo 'Acceso denegado. Se requiere rol de administrador.';
    exit;
}

// Incluir archivo de conexión a la base de datos
require_once '../connect.php';

try {
    // Consultar todos los usuarios con sus datos relevantes
    $query = "SELECT idusuarios, usuario, Nombre, Apellido, Correo, Celular, 
              rol, intentos_fallidos, bloqueado, fecha_bloqueo 
              FROM usuarios 
              ORDER BY bloqueado DESC, Apellido ASC, Nombre ASC";
    
    $result = $mysqli->query($query);
    
    if (!$result) {
        throw new Exception("Error en la consulta: " . $mysqli->error);
    }
    
    // Configurar cabeceras para descarga de archivo CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=usuarios_' . date('Y-m-d') . '.csv');
    
    // Crear un puntero de archivo en la salida
    $output = fopen('php://output', 'w');
    
    // Añadir BOM para UTF-8
    fprintf($output, "\xEF\xBB\xBF");
    
    // Escribir encabezados del CSV
    fputcsv($output, [
        'ID', 'Usuario', 'Nombre', 'Apellido', 'Correo', 'Celular',
        'Rol', 'Intentos Fallidos', 'Estado', 'Fecha Bloqueo'
    ]);
    
    // Escribir datos de usuarios
    while ($row = $result->fetch_assoc()) {
        // Formatear estado
        $estado = ($row['bloqueado'] == 1) ? 'Bloqueado' : 'Activo';
        
        // Escribir fila en el CSV
        fputcsv($output, [
            $row['idusuarios'],
            $row['usuario'],
            $row['Nombre'],
            $row['Apellido'],
            $row['Correo'],
            $row['Celular'],
            $row['rol'] ?: 'usuario',
            $row['intentos_fallidos'],
            $estado,
            $row['fecha_bloqueo']
        ]);
    }
    
    // Cerrar el resultado
    $result->free();
    
    // Registrar en la tabla de auditoría
    $admin_id = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : 0;
    $ip = $_SERVER['REMOTE_ADDR'];
    $detalles = "Exportación de usuarios a CSV";
    
    $query = "INSERT INTO auditoria (usuario_id, accion, ip, detalles) 
              VALUES (?, 'exportar_csv', ?, ?)";
    
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('iss', $admin_id, $ip, $detalles);
    $stmt->execute();
    
} catch (Exception $e) {
    // En caso de error, devolver mensaje de texto plano
    header('Content-Type: text/plain');
    echo 'Error al exportar usuarios: ' . $e->getMessage();
}